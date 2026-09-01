# Payment Processing Setup Guide

This guide walks through setting up the real payment processing system for Pinacare e-commerce.

## Prerequisites

- Laravel 9.x
- PHP 8.0+
- MySQL/MariaDB database
- Composer package manager

## Step 1: Install Required Dependencies

### Stripe PHP SDK

The Stripe payment service requires the official Stripe PHP SDK:

```bash
composer require stripe/stripe-php
```

### M-Pesa and PayPal

M-Pesa and PayPal integrations use Laravel's HTTP facade (guzzle), which is already included in the base Laravel installation.

**Verify Guzzle is installed:**
```bash
composer show guzzlehttp/guzzle
```

If not installed, add it:
```bash
composer require guzzlehttp/guzzle
```

## Step 2: Set Environment Variables

Add the following to your `.env` file:

```env
# M-Pesa (Safaricom Daraja API)
MPESA_CONSUMER_KEY=your_consumer_key_here
MPESA_CONSUMER_SECRET=your_consumer_secret_here
MPESA_PASSKEY=your_passkey_here
MPESA_SHORTCODE=your_shortcode_here
MPESA_CALLBACK_URL=https://yourdomain.com/api/webhooks/mpesa
MPESA_ENV=sandbox  # Change to 'production' for live

# Stripe
STRIPE_PUBLIC_KEY=pk_test_your_public_key_here
STRIPE_SECRET_KEY=sk_test_your_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here

# PayPal
PAYPAL_CLIENT_ID=your_client_id_here
PAYPAL_CLIENT_SECRET=your_client_secret_here
PAYPAL_MODE=sandbox  # Change to 'live' for production
PAYPAL_WEBHOOK_ID=your_webhook_id_here
```

See `.env.payment-gateways.example` for a complete template with all keys explained.

## Step 3: Run Database Migration

Create the new tables and columns for payment processing:

```bash
php artisan migrate
```

This will:
- Add `payment_notes` column to orders table
- Add `paypal_order_id` column to orders table
- Add `stripe_payment_intent_id` column to orders table
- Update order status enum to include `pending_payment`, `payment_failed`, and `refunded`

## Step 4: Get Payment Gateway Credentials

### M-Pesa (Safaricom)

1. Go to https://developer.safaricom.co.ke/
2. Create an account or login
3. Create a new app
4. Request access to Daraja APIs (STK Push, Query Transaction)
5. Get your Consumer Key and Consumer Secret
6. Use Sandbox environment for testing:
   - Shortcode: 174379 (test shortcode)
   - Passkey: bfb279f9aa9bdbcf158e97dd71a467cd2e625db89410a4fb10423db991d31922
   - Test phone: 254708374149 (use this for testing)

### Stripe

1. Go to https://dashboard.stripe.com/
2. Sign up or login
3. Go to Developers → API Keys
4. Copy your **Publishable key** (pk_test_...) → STRIPE_PUBLIC_KEY
5. Copy your **Secret key** (sk_test_...) → STRIPE_SECRET_KEY
6. Create a webhook endpoint:
   - Go to Developers → Webhooks
   - Add endpoint with URL: `https://yourdomain.com/api/webhooks/stripe`
   - Select events: `payment_intent.succeeded`, `payment_intent.payment_failed`
   - Copy the **Signing secret** → STRIPE_WEBHOOK_SECRET

### PayPal

1. Go to https://developer.paypal.com/
2. Sign in with your PayPal account (or create one)
3. Create an app or use the default app
4. Go to App Settings
5. In **Sandbox** section:
   - Copy **Client ID** → PAYPAL_CLIENT_ID
   - Copy **Secret** → PAYPAL_CLIENT_SECRET
6. Set up webhook:
   - Go to Webhooks in your Account Settings
   - Create webhook with URL: `https://yourdomain.com/api/webhooks/paypal`
   - Copy **Webhook ID** → PAYPAL_WEBHOOK_ID

## Step 5: Verify Installation

Check that all services can be instantiated:

```bash
php artisan tinker
```

Then run:

```php
// Test M-Pesa service
$mpesa = new App\Services\MpesaPaymentService();
echo "M-Pesa service OK\n";

// Test Stripe service
$stripe = new App\Services\StripePaymentService();
echo "Stripe service OK\n";

// Test PayPal service
$paypal = new App\Services\PayPalPaymentService();
echo "PayPal service OK\n";

// Test Payment orchestrator
$payment = new App\Services\PaymentService();
echo "Payment service OK\n";
```

Exit with `exit`

## Step 6: Configure Webhooks for Local Testing

### Using ngrok for Local Development

For testing webhooks locally, use ngrok to expose your local server:

```bash
# Download ngrok from https://ngrok.com/download
# Start ngrok
./ngrok http 8000

# This gives you a public URL like: https://xxxxx-xxx-xxxx.ngrok.io
```

Update your `.env`:
```env
MPESA_CALLBACK_URL=https://xxxxx-xxx-xxxx.ngrok.io/api/webhooks/mpesa
APP_URL=https://xxxxx-xxx-xxxx.ngrok.io
```

Then configure webhooks in each payment gateway dashboard with the ngrok URL.

### Stripe Local Testing

For Stripe, you can also use Stripe CLI:

```bash
# Install Stripe CLI from https://stripe.com/docs/stripe-cli
# Login to Stripe
stripe login

# Forward events to your local server
stripe listen --forward-to localhost:8000/api/webhooks/stripe

# This gives you a webhook signing secret to set in .env
```

### PayPal Sandbox Testing

PayPal webhooks should already be configured to sandbox mode. Test accounts are available in your PayPal Developer Dashboard.

## Step 7: Test the Payment Flow

### Test with M-Pesa (Sandbox)

1. Navigate to `/checkout`
2. Add items to cart
3. Select "M-Pesa" as payment method
4. Enter test phone: 254708374149
5. Check your phone for STK Push prompt
6. Enter PIN (any 4 digits in sandbox)
7. System should redirect to success page

### Test with Stripe

1. Navigate to `/checkout`
2. Add items to cart
3. Select "Card" as payment method
4. Use test card: 4242 4242 4242 4242
5. Enter any future expiry date
6. Enter any 3-digit CVC
7. Submit payment
8. Should see success page

**Test Cards:**
- Success: 4242 4242 4242 4242
- Require authentication: 4000 0025 0000 3155
- Decline: 4000 0000 0000 0002

### Test with PayPal

1. Navigate to `/checkout`
2. Add items to cart
3. Select "PayPal" as payment method
4. You'll be redirected to PayPal sandbox
5. Login with your sandbox account
6. Approve the payment
7. You'll be redirected back to success page

### Test Payment Failures

**M-Pesa:**
- Decline by not entering PIN or entering wrong PIN

**Stripe:**
- Use card: 4000 0000 0000 0002
- This will always decline

**PayPal:**
- Click Cancel on PayPal page
- Should redirect to cancellation page

## Step 8: Troubleshooting

### M-Pesa Issues

**"Authentication failed"**
- Check MPESA_CONSUMER_KEY and MPESA_CONSUMER_SECRET
- Verify you're using sandbox credentials for sandbox environment
- Check that MPESA_ENV is set correctly

**"Transaction timeout"**
- STK Push might not have appeared on phone
- Check that phone number is in correct format (254XXXXXXXXX)
- Try the transaction again

**Callback not received**
- Verify MPESA_CALLBACK_URL is publicly accessible
- Check firewall/network settings
- Use ngrok during local testing
- Monitor `storage/logs/laravel.log` for errors

### Stripe Issues

**"Invalid API Key"**
- Verify you're using the correct secret key (sk_test_...)
- Check there are no extra spaces in .env

**Webhook signature invalid**
- Make sure STRIPE_WEBHOOK_SECRET is correct
- Check webhook secret in Stripe Dashboard matches .env
- Use Stripe CLI for local testing

**Payment Intent not found**
- Verify payment_intent_id is being sent correctly
- Check that order exists in database

### PayPal Issues

**"Invalid Client"**
- Verify PAYPAL_CLIENT_ID and PAYPAL_CLIENT_SECRET
- Check you're using sandbox credentials in sandbox mode

**Webhook not received**
- Configure webhook in PayPal Developer Dashboard
- Check webhook URL is publicly accessible
- Verify webhook ID in .env

**Refund fails**
- Make sure order was successfully captured
- Check refund amount doesn't exceed captured amount

## Production Deployment

Before going live:

1. **Switch to Live Keys:**
   - Stripe: Use live keys (pk_live_... and sk_live_...)
   - PayPal: Change PAYPAL_MODE to 'live' and use live credentials
   - M-Pesa: Change MPESA_ENV to 'production' and use production credentials

2. **Configure SSL/HTTPS:**
   - All payment processing MUST use HTTPS
   - Update callback URLs to use https://

3. **Security Checklist:**
   - Never commit `.env` file to version control
   - Use strong, unique credentials
   - Enable webhook signature verification
   - Never log sensitive payment data
   - Set up proper error handling and monitoring

4. **Database Backups:**
   - Ensure regular backups are configured
   - Test backup restoration

5. **Monitor Logs:**
   - Set up log aggregation
   - Monitor for failed payments
   - Setup alerts for errors

6. **Test Full Flow:**
   - Process test transactions
   - Verify all order statuses
   - Check email notifications
   - Verify stock deductions only happen after payment

## Files Created

- `app/Services/PaymentService.php` - Orchestrator
- `app/Services/MpesaPaymentService.php` - M-Pesa integration
- `app/Services/StripePaymentService.php` - Stripe integration
- `app/Services/PayPalPaymentService.php` - PayPal integration
- `resources/views/storefront/payment/mpesa.blade.php` - M-Pesa UI
- `resources/views/storefront/payment/stripe.blade.php` - Stripe UI
- `resources/views/storefront/payment/paypal.blade.php` - PayPal UI
- `resources/views/storefront/payment/paypal-cancelled.blade.php` - PayPal cancellation

## Files Modified

- `app/Http/Controllers/CheckoutController.php`
- `app/Models/Order.php`
- `database/migrations/2026_09_01_000000_update_orders_table_for_payment_processing.php`
- `routes/web.php`
- `routes/api.php`
- `config/services.php`

## Support

For issues or questions:
- Stripe Docs: https://stripe.com/docs
- PayPal Docs: https://developer.paypal.com/docs
- M-Pesa Daraja: https://developer.safaricom.co.ke/
- Laravel Docs: https://laravel.com/docs
