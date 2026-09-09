<?php

namespace App\Services;

use App\Models\SavedCard;
use Illuminate\Support\Facades\Log;

/**
 * CardPaymentService
 * 
 * Generic card payment processor abstraction
 * Currently uses Stripe as the underlying provider
 * Can be extended to support multiple processors (Stripe, Flutterwave, PayPal, etc)
 */
class CardPaymentService
{
    protected $stripeService;

    public function __construct()
    {
        $this->stripeService = new StripePaymentService();
    }

    /**
     * Initiate a card payment (one-time charge)
     * 
     * @param Order $order
     * @param array $customerData ['email', 'name', 'phone', 'customer_id']
     * @return array
     */
    public function initiatePayment($order, $customerData = [])
    {
        try {
            Log::info('Card payment initiation', [
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'customer_email' => $customerData['email'] ?? null,
            ]);

            $result = $this->stripeService->createPaymentIntent($order, $customerData);

            if ($result['success']) {
                // Store payment intent ID for webhook processing
                $order->update([
                    'stripe_payment_intent_id' => $result['payment_intent_id'],
                    'payment_method' => 'card',
                ]);

                Log::info('Card payment intent created', [
                    'order_id' => $order->id,
                    'payment_intent_id' => $result['payment_intent_id'],
                ]);

                return [
                    'success' => true,
                    'client_secret' => $result['client_secret'],
                    'payment_intent_id' => $result['payment_intent_id'],
                    'amount' => $result['amount'],
                    'currency' => $result['currency'],
                ];
            }

            Log::error('Card payment intent creation failed', $result);
            return $result;

        } catch (\Exception $e) {
            Log::error('Card payment initiation error', [
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
     * Initiate payment with saved card (tokenized)
     * 
     * @param Order $order
     * @param SavedCard $savedCard
     * @return array
     */
    public function initiateWithSavedCard($order, SavedCard $savedCard)
    {
        try {
            Log::info('Saved card payment initiation', [
                'order_id' => $order->id,
                'saved_card_id' => $savedCard->id,
            ]);

            $result = $this->stripeService->confirmPaymentWithCard(
                $order,
                $savedCard->stripe_payment_method_id
            );

            return $result;

        } catch (\Exception $e) {
            Log::error('Saved card payment error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);

            return [
                'success' => false,
                'message' => 'Payment with saved card failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verify card payment status
     * Used after Stripe webhook or explicit verification
     */
    public function verifyPayment($paymentIntentId)
    {
        return $this->stripeService->verifyPayment($paymentIntentId);
    }

    /**
     * Process webhook callback from payment provider
     */
    public function handleWebhook($payload, $signature)
    {
        return $this->stripeService->handleWebhook($payload, $signature);
    }

    /**
     * Refund a card payment
     */
    public function refundPayment($chargeId, $amount = null)
    {
        return $this->stripeService->refundPayment($chargeId, $amount);
    }

    /**
     * Save a card for future use
     * Called after successful payment or explicit card save
     */
    public function saveCard($customerId, $paymentMethodId, $stripeCustomerId)
    {
        try {
            Log::info('Saving card', [
                'customer_id' => $customerId,
                'payment_method_id' => $paymentMethodId,
            ]);

            // Retrieve payment method details from Stripe
            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);

            if (!$paymentMethod || $paymentMethod->type !== 'card') {
                throw new \Exception('Invalid payment method');
            }

            $card = $paymentMethod->card;

            // Check if card already saved
            $existingCard = SavedCard::where('customer_id', $customerId)
                ->where('stripe_payment_method_id', $paymentMethodId)
                ->first();

            if ($existingCard) {
                Log::info('Card already saved', [
                    'saved_card_id' => $existingCard->id,
                ]);
                return ['success' => true, 'saved_card_id' => $existingCard->id];
            }

            // Save new card
            $savedCard = SavedCard::create([
                'customer_id' => $customerId,
                'stripe_payment_method_id' => $paymentMethodId,
                'stripe_customer_id' => $stripeCustomerId,
                'card_brand' => $card->brand ?? 'unknown',
                'card_last_four' => $card->last4,
                'card_exp_month' => $card->exp_month,
                'card_exp_year' => $card->exp_year,
                'cardholder_name' => $paymentMethod->billing_details?->name ?? null,
                'is_default' => SavedCard::where('customer_id', $customerId)->count() === 0, // First card is default
            ]);

            Log::info('Card saved successfully', [
                'saved_card_id' => $savedCard->id,
                'card_brand' => $savedCard->card_brand,
            ]);

            return [
                'success' => true,
                'saved_card_id' => $savedCard->id,
                'display_name' => $savedCard->getDisplayName(),
            ];

        } catch (\Exception $e) {
            Log::error('Card save failed', [
                'error' => $e->getMessage(),
                'customer_id' => $customerId,
            ]);

            return [
                'success' => false,
                'message' => 'Failed to save card: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get customer's saved cards
     */
    public function getSavedCards($customerId)
    {
        return SavedCard::where('customer_id', $customerId)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Delete a saved card
     */
    public function deleteSavedCard($savedCardId, $customerId)
    {
        try {
            $savedCard = SavedCard::where('id', $savedCardId)
                ->where('customer_id', $customerId)
                ->firstOrFail();

            // Detach from Stripe (optional - depends on compliance needs)
            // $this->stripeService->detachPaymentMethod($savedCard->stripe_payment_method_id);

            $savedCard->delete();

            Log::info('Card deleted', ['saved_card_id' => $savedCardId]);

            return ['success' => true];
        } catch (\Exception $e) {
            Log::error('Card deletion failed', [
                'error' => $e->getMessage(),
                'saved_card_id' => $savedCardId,
            ]);

            return [
                'success' => false,
                'message' => 'Failed to delete card: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Set a card as default
     */
    public function setDefaultCard($savedCardId, $customerId)
    {
        try {
            $savedCard = SavedCard::where('id', $savedCardId)
                ->where('customer_id', $customerId)
                ->firstOrFail();

            $savedCard->setAsDefault();

            Log::info('Default card updated', ['saved_card_id' => $savedCardId]);

            return ['success' => true];
        } catch (\Exception $e) {
            Log::error('Failed to set default card', [
                'error' => $e->getMessage(),
                'saved_card_id' => $savedCardId,
            ]);

            return [
                'success' => false,
                'message' => 'Failed to set default card: ' . $e->getMessage(),
            ];
        }
    }
}
