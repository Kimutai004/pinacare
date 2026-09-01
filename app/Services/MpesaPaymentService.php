<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * M-Pesa Payment Service - Integrates with Safaricom Daraja API
 * Requires: 
 *  - MPESA_CONSUMER_KEY in .env
 *  - MPESA_CONSUMER_SECRET in .env
 *  - MPESA_PASSKEY in .env
 *  - MPESA_SHORTCODE in .env
 *  - MPESA_CALLBACK_URL in .env
 */
class MpesaPaymentService
{
    private $consumerKey;
    private $consumerSecret;
    private $passkey;
    private $shortcode;
    private $callbackUrl;
    private $environment;

    public function __construct()
    {
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->passkey = config('services.mpesa.passkey');
        $this->shortcode = config('services.mpesa.shortcode');
        $this->callbackUrl = config('services.mpesa.callback_url');
        $this->environment = config('services.mpesa.environment', 'sandbox');
    }

    /**
     * Initiate M-Pesa STK Push payment
     * Prompts the customer to enter M-Pesa PIN on their phone
     */
    public function initiatePayment($order, $phoneNumber)
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Failed to get M-Pesa access token');
            }

            $timestamp = now()->format('YmdHis');
            $password = $this->encodePassword($this->shortcode, $this->passkey, $timestamp);

            $payload = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => ceil($order->total_amount),
                'PartyA' => $this->sanitizePhoneNumber($phoneNumber),
                'PartyB' => $this->shortcode,
                'PhoneNumber' => $this->sanitizePhoneNumber($phoneNumber),
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => 'ORDER-' . $order->id,
                'TransactionDesc' => 'Pinacare Order #' . $order->id,
            ];

            $baseUrl = $this->environment === 'production'
                ? 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
                : 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

            $response = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($baseUrl, $payload);

            $body = $response->json();
            
            Log::info('M-Pesa STK Push response', [
                'response' => $body,
                'order_id' => $order->id,
            ]);

            if ($response->successful() && isset($body['ResponseCode'])) {
                if ($body['ResponseCode'] === '0') {
                    return [
                        'success' => true,
                        'request_id' => $body['RequestId'] ?? null,
                        'checkout_request_id' => $body['CheckoutRequestID'] ?? null,
                        'message' => $body['ResponseDescription'] ?? 'STK Push sent successfully',
                    ];
                }
            }

            Log::error('M-Pesa STK Push failed', [
                'response' => $body,
                'status_code' => $response->status(),
                'order_id' => $order->id,
            ]);

            $errorMessage = $body['errorMessage'] ?? $body['ResponseDescription'] ?? 'Failed to initiate payment';
            return [
                'success' => false,
                'message' => $errorMessage,
            ];
        } catch (\Exception $e) {
            Log::error('M-Pesa payment initiation error', [
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
     * Handle callback from M-Pesa after payment
     * This is called by Safaricom after the customer completes/cancels payment
     */
    public function handleCallback($callbackData)
    {
        $result = $callbackData['Body']['stkCallback'] ?? [];

        $checkoutRequestId = $result['CheckoutRequestID'] ?? null;
        $resultCode = $result['ResultCode'] ?? null;
        $resultDesc = $result['ResultDesc'] ?? 'Unknown error';

        // ResultCode: 0 = Success, anything else = failed
        if ($resultCode === 0) {
            $callbackMetadata = $result['CallbackMetadata']['Item'] ?? [];
            $paymentData = $this->parseCallbackMetadata($callbackMetadata);

            return [
                'status' => 'success',
                'transaction_id' => $paymentData['MpesaReceiptNumber'] ?? $checkoutRequestId,
                'amount' => $paymentData['Amount'] ?? 0,
                'payment_gateway' => 'mpesa',
                'phone_number' => $paymentData['PhoneNumber'] ?? null,
            ];
        } else {
            return [
                'status' => 'failed',
                'reason' => $resultDesc,
                'payment_gateway' => 'mpesa',
            ];
        }
    }

    /**
     * Query payment status from M-Pesa
     * Useful to verify payment status without relying on callback
     */
    public function queryPaymentStatus($checkoutRequestId)
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Failed to get M-Pesa access token');
            }

            $timestamp = now()->format('YmdHis');
            $password = $this->encodePassword($this->shortcode, $this->passkey, $timestamp);

            $payload = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkoutRequestId,
            ];

            $baseUrl = $this->environment === 'production'
                ? 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query'
                : 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';

            $response = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($baseUrl, $payload);

            if ($response->successful()) {
                $body = $response->json();
                if ($body['ResponseCode'] === '0') {
                    return [
                        'status' => $body['ResultCode'] === 0 ? 'success' : 'pending',
                        'response_code' => $body['ResponseCode'],
                        'message' => $body['ResponseDescription'],
                    ];
                }
            }

            return [
                'status' => 'unknown',
                'message' => $response->json()['ResponseDescription'] ?? 'Query failed',
            ];
        } catch (\Exception $e) {
            Log::error('M-Pesa status query error', ['error' => $e->getMessage()]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get OAuth access token from Safaricom
     */
    private function getAccessToken()
    {
        try {
            $baseUrl = $this->environment === 'production'
                ? 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
                : 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get($baseUrl);

            if ($response->successful()) {
                return $response->json()['access_token'] ?? null;
            }

            Log::error('M-Pesa token generation failed', ['response' => $response->json()]);
            return null;
        } catch (\Exception $e) {
            Log::error('M-Pesa token error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Encode password for M-Pesa API
     */
    private function encodePassword($businessShortCode, $passkey, $timestamp)
    {
        $input = $businessShortCode . $passkey . $timestamp;
        return base64_encode($input);
    }

    /**
     * Sanitize phone number to Safaricom format (254XXXXXXXXX)
     */
    private function sanitizePhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        } elseif (substr($phone, 0, 3) !== '254') {
            $phone = '254' . $phone;
        }

        return $phone;
    }

    /**
     * Parse callback metadata from M-Pesa
     */
    private function parseCallbackMetadata($items)
    {
        $data = [];
        foreach ($items as $item) {
            $data[$item['Name']] = $item['Value'] ?? null;
        }
        return $data;
    }
}
