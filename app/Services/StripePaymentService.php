<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Illuminate\Support\Facades\Log;

/**
 * Stripe Payment Service
 * Requires:
 *  - STRIPE_PUBLIC_KEY in .env
 *  - STRIPE_SECRET_KEY in .env
 *  - STRIPE_SECRET in .env
 */
class StripePaymentService
{
    private $secretKey;
    private $webhookSecret;

    public function __construct()
    {
        $this->secretKey = config('services.stripe.secret');
        $this->webhookSecret = config('services.stripe.webhook_secret');
        Stripe::setApiKey($this->secretKey);
    }

    /**
     * Create a Stripe Payment Intent
     * This initiates the payment flow and returns a client secret for frontend
     */
    public function createPaymentIntent($order, $customerData = [])
    {
        try {
            // Create or get Stripe customer
            $stripeCustomer = $this->getOrCreateCustomer(
                $customerData['email'] ?? null,
                $customerData['name'] ?? null,
                $customerData['phone'] ?? null
            );

            // Create payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($order->total_amount * 100), // Amount in cents
                'currency' => 'kes', // Kenyan Shilling
                'customer' => $stripeCustomer->id,
                'payment_method_types' => ['card'],
                'description' => 'Order #' . $order->id . ' from Pinacare',
                'metadata' => [
                    'order_id' => $order->id,
                    'customer_email' => $customerData['email'] ?? null,
                ],
                'receipt_email' => $customerData['email'] ?? null,
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe payment intent creation failed', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create payment: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verify Payment Intent status
     * Called after frontend confirms payment
     */
    public function verifyPayment($paymentIntentId)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status === 'succeeded') {
                return [
                    'status' => 'success',
                    'transaction_id' => $paymentIntent->id,
                    'charge_id' => $paymentIntent->latest_charge,
                    'amount' => $paymentIntent->amount / 100,
                    'payment_gateway' => 'stripe',
                ];
            } elseif ($paymentIntent->status === 'processing') {
                return [
                    'status' => 'pending',
                    'transaction_id' => $paymentIntent->id,
                    'message' => 'Payment is processing',
                ];
            } else {
                return [
                    'status' => 'failed',
                    'reason' => 'Payment ' . $paymentIntent->status,
                    'payment_gateway' => 'stripe',
                ];
            }
        } catch (\Exception $e) {
            Log::error('Stripe payment verification failed', [
                'error' => $e->getMessage(),
                'payment_intent_id' => $paymentIntentId,
            ]);

            return [
                'status' => 'error',
                'message' => 'Verification failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Handle Stripe webhook (payment_intent.succeeded, etc.)
     */
    public function handleWebhook($payload, $signature)
    {
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                $this->webhookSecret
            );

            if ($event['type'] === 'payment_intent.succeeded') {
                $paymentIntent = $event['data']['object'];
                
                return [
                    'event_type' => 'payment_succeeded',
                    'order_id' => $paymentIntent['metadata']['order_id'] ?? null,
                    'transaction_id' => $paymentIntent['id'],
                    'amount' => $paymentIntent['amount'] / 100,
                    'status' => 'success',
                ];
            } elseif ($event['type'] === 'payment_intent.payment_failed') {
                $paymentIntent = $event['data']['object'];
                
                return [
                    'event_type' => 'payment_failed',
                    'order_id' => $paymentIntent['metadata']['order_id'] ?? null,
                    'transaction_id' => $paymentIntent['id'],
                    'status' => 'failed',
                    'reason' => $paymentIntent['last_payment_error']['message'] ?? 'Payment failed',
                ];
            }

            return ['event_type' => 'ignored'];
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed', [
                'error' => $e->getMessage(),
            ]);
            return ['error' => 'Invalid signature'];
        } catch (\Exception $e) {
            Log::error('Stripe webhook processing error', [
                'error' => $e->getMessage(),
            ]);
            return ['error' => 'Webhook processing failed'];
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment($chargeId, $amount = null)
    {
        try {
            $refund = \Stripe\Refund::create([
                'charge' => $chargeId,
                'amount' => $amount ? (int)($amount * 100) : null,
            ]);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'amount' => $refund->amount / 100,
                'status' => $refund->status,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe refund failed', [
                'error' => $e->getMessage(),
                'charge_id' => $chargeId,
            ]);

            return [
                'success' => false,
                'message' => 'Refund failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Confirm payment using saved card (payment method)
     * Directly charges the saved card without requiring 3D Secure flow
     */
    public function confirmPaymentWithCard($order, $paymentMethodId)
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($order->total_amount * 100),
                'currency' => 'kes', // Kenyan Shilling
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'off_session' => true,
                'description' => 'Order #' . $order->id . ' (Saved Card)',
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            return [
                'status' => 'success',
                'transaction_id' => $paymentIntent->id,
                'charge_id' => $paymentIntent->latest_charge,
                'amount' => $paymentIntent->amount / 100,
                'payment_gateway' => 'stripe',
            ];
        } catch (\Exception $e) {
            Log::error('Stripe saved card payment failed', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);

            return [
                'status' => 'failed',
                'reason' => $e->getMessage(),
            ];
        }
    }

    /**
     * Detach payment method from customer (for deletion)
     */
    public function detachPaymentMethod($paymentMethodId)
    {
        try {
            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->detach();
            return ['success' => true];
        } catch (\Exception $e) {
            Log::error('Payment method detach failed', [
                'error' => $e->getMessage(),
            ]);
            return ['success' => false];
        }
    }

    /**
     * Create or retrieve Stripe customer
     */
    public function getOrCreateCustomer($email, $name = null, $phone = null)
    {
        try {
            // Search for existing customer by email
            $customers = Customer::all(['email' => $email, 'limit' => 1]);
            
            if ($customers->data && count($customers->data) > 0) {
                return $customers->data[0];
            }

            // Create new customer
            return Customer::create([
                'email' => $email,
                'name' => $name,
                'phone' => $phone,
                'metadata' => [
                    'source' => 'pinacare_storefront',
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe customer creation/retrieval failed', [
                'error' => $e->getMessage(),
                'email' => $email,
            ]);

            throw $e;
        }
    }
}
