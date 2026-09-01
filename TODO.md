# Product Photo Upload & Display

- [x] 0. Explore admin product views, controller, model, migration, storefront views
- [x] 1. Update `ProductController` store/update to accept `image` file upload
- [x] 2. Update `create.blade.php`: add multipart form + file input + preview
- [x] 3. Update `edit.blade.php`: add multipart form + file input + preview of current image
- [x] 4. Update admin `index.blade.php` to show product photo thumbnail
- [x] 5. Update storefront `products/index.blade.php` to display photo
- [x] 6. Update storefront `products/show.blade.php` to display photo
- [x] 7. Ensure `storage:link` symlink is present

# Payment Processing Implementation

## ✅ COMPLETED - Phase 1: Service Layer & Infrastructure

- [x] 1. Create PaymentService.php (orchestrator with atomic confirmPayment, handlePaymentFailure, refundOrder)
- [x] 2. Create MpesaPaymentService.php (Safaricom Daraja API integration)
- [x] 3. Create StripePaymentService.php (Stripe Payment Intent integration)
- [x] 4. Create PayPalPaymentService.php (PayPal REST API integration)
- [x] 5. Refactor CheckoutController.php to create orders with pending_payment status (no premature stock deduction)
- [x] 6. Update Order.php model with new fields and helper methods
- [x] 7. Create database migration for payment tracking columns
- [x] 8. Add payment callback routes to web.php
- [x] 9. Add webhook routes to api.php
- [x] 10. Update config/services.php with all payment gateway configurations

## ✅ COMPLETED - Phase 2: User Interface

- [x] 1. Create resources/views/storefront/payment/mpesa.blade.php (STK Push waiting screen with polling)
- [x] 2. Create resources/views/storefront/payment/stripe.blade.php (Stripe Elements card form)
- [x] 3. Create resources/views/storefront/payment/paypal.blade.php (PayPal button with redirect)
- [x] 4. Create resources/views/storefront/payment/paypal-cancelled.blade.php (cancellation handling)

## ✅ COMPLETED - Phase 3: Documentation

- [x] 1. Create PAYMENT_IMPLEMENTATION.md (architecture and design guide)
- [x] 2. Create PAYMENT_SETUP_GUIDE.md (installation and configuration guide)
- [x] 3. Create .env.payment-gateways.example (environment variable template)

## 🔄 TODO - Phase 4: Webhook Handler Controller

- [ ] 1. Create or update PaymentController.php with mpesaWebhook() handler
- [ ] 2. Implement stripeWebhook() handler for /api/webhooks/stripe
- [ ] 3. Implement paypalWebhook() handler for /api/webhooks/paypal
- [ ] 4. Add webhook signature validation for each gateway
- [ ] 5. Route all webhooks to PaymentService::confirmPayment() on success

## 🔄 TODO - Phase 5: Testing & Validation

- [ ] 1. Composer require stripe/stripe-php
- [ ] 2. Add payment gateway credentials to .env
- [ ] 3. Run: php artisan migrate (to update orders table schema)
- [ ] 4. Test M-Pesa checkout flow end-to-end
- [ ] 5. Test Stripe checkout flow end-to-end
- [ ] 6. Test PayPal checkout flow end-to-end
- [ ] 7. Test payment failure scenarios for each gateway
- [ ] 8. Verify stock is NOT deducted before payment confirmation
- [ ] 9. Verify stock IS deducted only after payment success
- [ ] 10. Verify order status lifecycle: pending_payment → paid (on success) or payment_failed (on failure)
- [ ] 11. Test webhook signature validation
- [ ] 12. Create unit tests for PaymentService::confirmPayment()
- [ ] 13. Create unit tests for each PaymentService implementation

## 🔄 TODO - Phase 6: Security & Production

- [ ] 1. Verify CSRF protection on checkout form
- [ ] 2. Add rate limiting to payment callback endpoints
- [ ] 3. Add error handling to hide sensitive details in user-facing errors
- [ ] 4. Setup proper logging (without logging sensitive payment data)
- [ ] 5. Configure webhook verification for all three gateways in production
- [ ] 6. Setup payment failure alerts/notifications
- [ ] 7. Configure email notifications for successful orders
- [ ] 8. Add refund request handling UI
- [ ] 9. Setup payment reconciliation/audit logging

## 🔄 TODO - Phase 7: Enhancement Features (Future)

- [ ] 1. Add payment retry mechanism for failed transactions
- [ ] 2. Add subscription billing with Stripe Billing
- [ ] 3. Add saved payment methods feature
- [ ] 4. Add digital receipt/invoice generation
- [ ] 5. Add payment status dashboard for admins
- [ ] 6. Add customer payment history
- [ ] 7. Add multi-currency support
- [ ] 8. Add payment analytics/reporting

