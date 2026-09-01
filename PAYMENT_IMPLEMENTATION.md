# Payment Processing Implementation

This document describes the real payment processing system for Pinacare e-commerce.

## Architecture Overview

### Key Change: Stock Deduction After Payment

**Before (Bug):** Stock was deducted immediately when order was created, before payment verification.

**After (Fixed):** 
1. Order created with status `pending_payment`
2. No stock is deducted
3. Payment gateway is initiated
4. **ONLY after payment confirmation** is stock deducted via `PaymentService::confirmPayment()`
5. Order status changed to `paid`

### Service Layer Architecture

```
CheckoutController
    ↓
    └─→ PaymentService (orchestrator)
            ├─→ MpesaPaymentService
            ├─→ StripePaymentService
            └─→ PayPalPaymentService
```

## Payment Services

### 1. PaymentService (app/Services/PaymentService.php)

Central orchestrator for all payment operations.

**Key Methods:**

- `confirmPayment($order, $paymentData)`: 
  - Wrapped in DB::transaction()
  - Verifies payment status is 'success'
  - Deducts stock for all order items
  - Updates impact metrics (diapers_saved, co2_reduced, farmers_supported)
  - Creates Payment record
  - Updates order status to 'paid'
  
- `handlePaymentFailure($order, $reason)`:
  - Sets order status to 'payment_failed'
  - Stores failure reason in payment_notes
  - Allows customer to retry payment
  
- `refundOrder($order)`:
  - Restores stock for all items
  - Reverses impact metrics
  - Updates payment status to 'refunded'
  - Sets order status to 'refunded'

### 2. MpesaPaymentService (app/Services/MpesaPaymentService.php)

Safaricom Daraja API integration for M-Pesa STK Push payments.

**Key Methods:**

- `initiatePayment($order, $phoneNumber)`:
  - Gets OAuth token from Safaricom
  - Creates base64 password: base64(shortcode + passkey + timestamp)
  - Sends STK Push request
  - Returns checkout_request_id and message
  
- `handleCallback($callbackData)`:
  - Parses webhook from Safaricom
  - ResultCode 0 = success, non-zero = failed
  - Extracts transaction ID and amount
  - Returns payment data for confirmPayment()
  
- `queryPaymentStatus($checkoutRequestId)`:
  - Independent status check using CheckoutRequestID
  - Useful for polling or manual verification

**Configuration (.env):**
```
MPESA_CONSUMER_KEY=xxxxx
MPESA_CONSUMER_SECRET=xxxxx
MPESA_PASSKEY=xxxxx
MPESA_SHORTCODE=xxxxx (e.g., 174379)
MPESA_CALLBACK_URL=https://yourdomain.com/api/webhooks/mpesa
MPESA_ENV=sandbox  # or production
```

### 3. StripePaymentService (app/Services/StripePaymentService.php)

Stripe Payment Intent integration.

**Key Methods:**

- `createPaymentIntent($order, $customerData)`:
  - Creates/retrieves Stripe customer
  - Creates PaymentIntent with order metadata
  - Returns client_secret for frontend payment form
  
- `verifyPayment($paymentIntentId)`:
  - Checks intent status: succeeded/processing/failed
  - Returns payment data
  
- `handleWebhook($payload, $signature)`:
  - Validates webhook signature
  - Processes payment_intent.succeeded and payment_intent.payment_failed events
  
- `refundPayment($chargeId, $amount = null)`:
  - Full or partial refunds via Stripe Refund API

**Configuration (.env):**
```
STRIPE_PUBLIC_KEY=pk_test_xxxxx
STRIPE_SECRET_KEY=sk_test_xxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxx
```

### 4. PayPalPaymentService (app/Services/PayPalPaymentService.php)

PayPal REST API integration.

**Key Methods:**

- `createOrder($order, $customerData)`:
  - Creates PayPal order with purchase units and items
  - Returns order ID and approval URL
  
- `captureOrder($paypalOrderId)`:
  - Called after customer approves on PayPal
  - Captures payment
  - Returns payment data
  
- `handleWebhook($webhookData)`:
  - Processes CHECKOUT.ORDER.COMPLETED and CHECKOUT.ORDER.APPROVED events
  
- `refundPayment($captureId, $amount = null)`:
  - Full or partial refunds

**Configuration (.env):**
```
PAYPAL_CLIENT_ID=xxxxx
PAYPAL_CLIENT_SECRET=xxxxx
PAYPAL_MODE=sandbox  # or live
PAYPAL_WEBHOOK_ID=xxxxx
```

## Order Flow

### 1. Checkout Page
```
GET /checkout
→ Displays cart with payment method selection (M-Pesa, Card/Stripe, PayPal)
```

### 2. Place Order
```
POST /checkout
→ CheckoutController::store()
  ├─ Verify stock availability
  ├─ Create Customer
  ├─ Create Order with status='pending_payment'  ← KEY CHANGE
  ├─ Create OrderItems (NO stock deduction yet)
  └─ Redirect to payment processor
```

### 3. Payment Processing (varies by method)

**M-Pesa Flow:**
```
1. Initiate STK Push
   POST /checkout → CheckoutController::initiateMpesa()
   → MpesaPaymentService::initiatePayment()
   → Show waiting page with user prompting phone

2. Customer enters PIN on phone

3. Safaricom sends callback
   POST /api/webhooks/mpesa → CheckoutController::mpesaCallback()
   → Calls PaymentService::confirmPayment()  ← Stock deducted here
   → Clear cart, redirect to success
```

**Stripe Flow:**
```
1. Create Payment Intent
   POST /checkout → CheckoutController::initiateStripe()
   → StripePaymentService::createPaymentIntent()
   → Show Stripe payment form with client_secret

2. Customer enters card details in form

3. Frontend verifies intent
   POST /payment/stripe/callback → CheckoutController::stripeCallback()
   → Calls PaymentService::confirmPayment()  ← Stock deducted here
   → Clear cart, redirect to success
```

**PayPal Flow:**
```
1. Create PayPal Order
   POST /checkout → CheckoutController::initiatePaypal()
   → PayPalPaymentService::createOrder()
   → Redirect to PayPal for approval

2. Customer approves on PayPal

3. Customer redirected back
   GET /payment/paypal/return → CheckoutController::paypalReturn()
   → PayPalPaymentService::captureOrder()
   → Calls PaymentService::confirmPayment()  ← Stock deducted here
   → Clear cart, redirect to success
```

## Database Migrations

Created migration: `2026_09_01_000000_update_orders_table_for_payment_processing.php`

Adds to orders table:
- `payment_notes` (text, nullable): Stores payment failure reasons or notes
- `paypal_order_id` (string, nullable): Stores PayPal order ID
- `stripe_payment_intent_id` (string, nullable): Stores Stripe PaymentIntent ID

Updates status enum to include:
- `pending_payment`: Payment in progress
- `payment_failed`: Payment failed (customer can retry)
- `refunded`: Order refunded

## Order Model Updates

[app/Models/Order.php](app/Models/Order.php)

Added helper methods:
- `isPaid()`: Check if order status is 'paid'
- `isPaymentPending()`: Check if status is 'pending_payment'
- `isPaymentFailed()`: Check if status is 'payment_failed'

Updated fillable to include new fields:
- `payment_notes`
- `paypal_order_id`
- `stripe_payment_intent_id`

## Routes

### Web Routes (resources/views/)
- `POST /checkout` - Place order and initiate payment
- `GET /checkout/success/{order}` - Order confirmation (only if order is paid)
- `POST /payment/mpesa/callback` - M-Pesa webhook callback
- `POST /payment/stripe/callback` - Stripe payment verification
- `GET /payment/paypal/return` - PayPal approval return
- `GET /payment/paypal/cancel` - PayPal cancellation

### API Routes (webhooks)
- `POST /api/webhooks/mpesa` - Safaricom M-Pesa callbacks
- `POST /api/webhooks/stripe` - Stripe webhook events
- `POST /api/webhooks/paypal` - PayPal IPN/webhooks

## Configuration

Updated [config/services.php](config/services.php) with payment gateway configs:

```php
'mpesa' => [
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    'passkey' => env('MPESA_PASSKEY'),
    'shortcode' => env('MPESA_SHORTCODE'),
    'callback_url' => env('MPESA_CALLBACK_URL'),
    'environment' => env('MPESA_ENV', 'sandbox'),
],

'stripe' => [
    'public' => env('STRIPE_PUBLIC_KEY'),
    'secret' => env('STRIPE_SECRET_KEY'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
],

'paypal' => [
    'client_id' => env('PAYPAL_CLIENT_ID'),
    'client_secret' => env('PAYPAL_CLIENT_SECRET'),
    'mode' => env('PAYPAL_MODE', 'sandbox'),
    'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
],
```

See [.env.payment-gateways.example](.env.payment-gateways.example) for all required environment variables.

## Atomic Transaction Guarantee

All payment confirmations use `DB::transaction()` to ensure:

```php
DB::transaction(function () {
    // 1. Verify payment
    // 2. Deduct stock
    // 3. Update impact metrics
    // 4. Create Payment record
    // 5. Update order status
    // All or nothing - if any step fails, entire transaction rolls back
});
```

This ensures **stock is NEVER deducted unless payment is confirmed**.

## Error Handling

### Payment Failures
- Order remains in `pending_payment` status
- `payment_notes` stores failure reason
- Customer can retry checkout or abandon order
- Stock remains unchanged

### Refunds
- `PaymentService::refundOrder($order)` handles full refunds
- Restores stock increments
- Reverses impact metrics
- Updates Payment status to 'refunded'

## Next Steps

1. **Create Payment Processing Views:**
   - `resources/views/storefront/payment/mpesa.blade.php` - M-Pesa waiting screen
   - `resources/views/storefront/payment/stripe.blade.php` - Stripe Elements form
   - `resources/views/storefront/payment/paypal.blade.php` - PayPal button
   - `resources/views/storefront/payment/paypal-cancelled.blade.php` - PayPal cancellation

2. **Frontend JavaScript:**
   - Stripe Elements integration (card input)
   - PayPal SDK integration (button)
   - M-Pesa polling for payment status

3. **Test Credentials:**
   - M-Pesa: Get from Safaricom Daraja portal (sandbox mode available)
   - Stripe: Use test keys from Stripe Dashboard
   - PayPal: Use sandbox mode credentials

4. **Webhook Configuration:**
   - Configure callback URLs in payment gateway dashboards
   - M-Pesa: Add callback URL in Daraja portal
   - Stripe: Add webhook endpoint in Stripe Dashboard
   - PayPal: Create webhook listeners in PayPal Developer Dashboard

5. **Security Considerations:**
   - Never log sensitive payment data (card numbers, etc.)
   - Validate all webhook signatures
   - Use HTTPS for all payment-related endpoints
   - Store encrypted payment tokens
   - Never store full card numbers

## Troubleshooting

### M-Pesa Issues
- Check MPESA_CONSUMER_KEY and MPESA_CONSUMER_SECRET
- Verify phone number format (254XXXXXXXXX)
- Check MPESA_CALLBACK_URL is publicly accessible
- Test with sandbox credentials first

### Stripe Issues
- Verify STRIPE_SECRET_KEY starts with 'sk_'
- Check webhook secret is correctly set
- Use Stripe CLI for local webhook testing
- Check Stripe Dashboard for failed events

### PayPal Issues
- Verify API signature for IPN
- Check return/cancel URLs are correct
- Use sandbox mode for testing
- Monitor PayPal logs in developer account
