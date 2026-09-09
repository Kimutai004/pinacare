<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * PayPal Payment Service
 * Requires:
 *  - PAYPAL_CLIENT_ID in .env
 *  - PAYPAL_CLIENT_SECRET in .env
 *  - PAYPAL_MODE in .env (sandbox or live)
 */
class PayPalPaymentService
{
    private $clientId;
    private $clientSecret;
    private $mode;
    private $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
        $this->mode = config('services.paypal.mode', 'sandbox');
        $this->baseUrl = $this->mode === 'live'
            ? 'https://api.paypal.com'
            : 'https://api.sandbox.paypal.com';
    }

    /**
     * Create PayPal order
     * Returns order ID and approval URL
     */
    public function createOrder($order, $customerData = [])
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Failed to get PayPal access token');
            }

            $items = $order->items->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'quantity' => (string)$item->quantity,
                    'unit_amount' => [
                        'currency_code' => 'USD', // Change to KES if PayPal supports it
                        'value' => (string)number_format($item->price, 2, '.', ''),
                    ],
                ];
            })->toArray();

            $payload = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => 'ORDER-' . $order->id,
                        'description' => 'Pinacare Order #' . $order->id,
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => (string)number_format($order->total_amount, 2, '.', ''),
                            'breakdown' => [
                                'item_total' => [
                                    'currency_code' => 'USD',
                                    'value' => (string)number_format($order->total_amount, 2, '.', ''),
                                ],
                            ],
                        ],
                        'items' => $items,
                    ],
                ],
                'payer' => [
                    'name' => [
                        'given_name' => $customerData['name'] ?? 'Customer',
                        'surname' => '',
                    ],
                    'email_address' => $customerData['email'] ?? null,
                    'phone' => [
                        'phone_number' => [
                            'national_number' => $customerData['phone'] ?? null,
                        ],
                    ],
                ],
                'application_context' => [
                    'return_url' => route('store.checkout.paypal.return'),
                    'cancel_url' => route('store.checkout.paypal.cancel'),
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                ],
            ];

            $response = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->baseUrl . '/v2/checkout/orders', $payload);

            if ($response->successful()) {
                $body = $response->json();
                
                // Find approval link
                $approvalUrl = null;
                foreach ($body['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approvalUrl = $link['href'];
                        break;
                    }
                }

                return [
                    'success' => true,
                    'order_id' => $body['id'],
                    'approval_url' => $approvalUrl,
                    'status' => $body['status'],
                ];
            }

            Log::error('PayPal order creation failed', [
                'response' => $response->json(),
                'order_id' => $order->id,
            ]);

            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'Failed to create PayPal order',
            ];
        } catch (\Exception $e) {
            Log::error('PayPal order creation error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);

            return [
                'success' => false,
                'message' => 'Payment initiation failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Capture PayPal order (after customer approves on PayPal)
     */
    public function captureOrder($paypalOrderId)
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Failed to get PayPal access token');
            }

            $response = Http::withToken($accessToken)
                ->post($this->baseUrl . '/v2/checkout/orders/' . $paypalOrderId . '/capture');

            if ($response->successful()) {
                $body = $response->json();
                
                if ($body['status'] === 'COMPLETED') {
                    $capture = $body['purchase_units'][0]['payments']['captures'][0] ?? null;
                    
                    return [
                        'status' => 'success',
                        'transaction_id' => $capture['id'] ?? $paypalOrderId,
                        'amount' => $capture['amount']['value'] ?? 0,
                        'payment_gateway' => 'paypal',
                        'payer_email' => $body['payer']['email_address'] ?? null,
                    ];
                }
            }

            Log::error('PayPal order capture failed', [
                'response' => $response->json(),
                'paypal_order_id' => $paypalOrderId,
            ]);

            return [
                'status' => 'failed',
                'reason' => $response->json()['message'] ?? 'Capture failed',
                'payment_gateway' => 'paypal',
            ];
        } catch (\Exception $e) {
            Log::error('PayPal capture error', [
                'error' => $e->getMessage(),
                'paypal_order_id' => $paypalOrderId,
            ]);

            return [
                'status' => 'error',
                'message' => 'Capture failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Handle PayPal webhook notifications
     */
    public function handleWebhook($webhookData)
    {
        $eventType = $webhookData['event_type'] ?? null;

        if ($eventType === 'CHECKOUT.ORDER.COMPLETED') {
            $resource = $webhookData['resource'] ?? [];
            $capture = $resource['purchase_units'][0]['payments']['captures'][0] ?? null;

            return [
                'event_type' => 'payment_completed',
                'paypal_order_id' => $resource['id'] ?? null,
                'transaction_id' => $capture['id'] ?? null,
                'status' => 'success',
                'amount' => $capture['amount']['value'] ?? 0,
            ];
        } elseif ($eventType === 'CHECKOUT.ORDER.APPROVED') {
            return [
                'event_type' => 'payment_approved',
                'paypal_order_id' => $webhookData['resource']['id'] ?? null,
                'status' => 'pending',
            ];
        }

        return ['event_type' => 'ignored'];
    }

    /**
     * Refund a payment
     */
    public function refundPayment($captureId, $amount = null)
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Failed to get PayPal access token');
            }

            $payload = [];
            if ($amount) {
                $payload['amount'] = [
                    'currency_code' => 'USD',
                    'value' => (string)number_format($amount, 2, '.', ''),
                ];
            }

            $response = Http::withToken($accessToken)
                ->post($this->baseUrl . '/v2/payments/captures/' . $captureId . '/refund', $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'refund_id' => $response->json()['id'],
                    'status' => $response->json()['status'],
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'Refund failed',
            ];
        } catch (\Exception $e) {
            Log::error('PayPal refund failed', [
                'error' => $e->getMessage(),
                'capture_id' => $captureId,
            ]);

            return [
                'success' => false,
                'message' => 'Refund failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get access token from PayPal
     */
    private function getAccessToken()
    {
        try {
            $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
                ->asForm()
                ->post($this->baseUrl . '/v1/oauth2/token', [
                    'grant_type' => 'client_credentials',
                ]);

            if ($response->successful()) {
                return $response->json()['access_token'] ?? null;
            }

            Log::error('PayPal token generation failed', ['response' => $response->json()]);
            return null;
        } catch (\Exception $e) {
            Log::error('PayPal token error', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
