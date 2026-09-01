@extends('storefront.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Card Payment</h1>
            <p class="text-gray-600">Complete your purchase with a secure card payment</p>
        </div>

        <!-- Order Summary -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
            <div class="space-y-3">
                <div class="flex justify-between text-gray-600">
                    <span>Order ID:</span>
                    <span class="font-semibold text-gray-800">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Items:</span>
                    <span class="font-semibold text-gray-800">{{ $order->items ? $order->items->count() : 0 }}</span>
                </div>
                <hr class="my-3">
                <div class="flex justify-between text-lg">
                    <span class="font-semibold text-gray-800">Total Amount:</span>
                    <span class="font-bold text-blue-600">Ksh {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Payment Details</h2>

            <!-- Saved Cards Option (if available) -->
            @if($shouldSaveCard && count($savedCards) > 0)
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-3">Use Saved Card</label>
                    <div class="space-y-2">
                        @foreach($savedCards as $card)
                            <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-400 cursor-pointer"
                                 onclick="selectSavedCard({{ $card->id }}, '{{ $card->card_brand }}', '{{ $card->card_last_four }}')">
                                <input type="radio" name="payment_method" value="saved_card_{{ $card->id }}"
                                       class="mr-3" onchange="useSavedCard({{ $card->id }})">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">
                                        {{ ucfirst($card->card_brand) }} ending in {{ $card->card_last_four }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Expires {{ $card->card_exp_month }}/{{ $card->card_exp_year }}
                                        @if($card->isExpired())
                                            <span class="text-red-500 font-semibold">(Expired)</span>
                                        @endif
                                    </div>
                                    @if($card->is_default)
                                        <span class="inline-block text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded mt-1">
                                            Default
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-6">
                    <label class="flex items-center text-gray-700">
                        <input type="radio" name="payment_method" value="new_card"
                               class="mr-3" checked onchange="useNewCard()">
                        <span>Use a new card</span>
                    </label>
                </div>
            @endif

            <!-- New Card Form -->
            <form id="card-form" class="space-y-4">
                <!-- Cardholder Name -->
                <div>
                    <label for="cardholder-name" class="block text-gray-700 font-semibold mb-2">
                        Cardholder Name
                    </label>
                    <input type="text" id="cardholder-name" name="cardholder_name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="John Doe" required>
                </div>

                <!-- Stripe Card Element -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Card Details</label>
                    <div id="card-element" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus-within:border-blue-500"></div>
                    <div id="card-errors" class="text-red-500 text-sm mt-2"></div>
                </div>

                <!-- Save Card Checkbox (for logged-in users) -->
                @if($shouldSaveCard)
                    <div class="flex items-center">
                        <input type="checkbox" id="save-card" name="save_card" value="1"
                               class="mr-2 rounded border-gray-300">
                        <label for="save-card" class="text-gray-700">
                            Save this card for future purchases
                        </label>
                    </div>
                @endif

                <!-- Payment Button -->
                <button type="submit" id="payment-button"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2"
                        disabled>
                    <span id="button-text">Processing Payment...</span>
                </button>
            </form>

            <!-- Security Info -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm">
                        <p class="font-semibold text-blue-900 mb-1">Secure Payment</p>
                        <p class="text-blue-800">Your payment is encrypted and processed securely by Stripe. We never store your card details.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Status Indicator -->
        <div id="payment-status" class="hidden mb-8 p-4 rounded-lg border">
            <div class="flex items-center gap-2">
                <div class="animate-spin">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 5.293a1 1 0 011.414 0A7 7 0 0016.708 11.5h-2.828a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.172A9 9 0 105.707 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span id="status-message" class="text-gray-700">Processing payment...</span>
            </div>
        </div>

        <!-- Error Alert -->
        <div id="error-alert" class="hidden mb-8 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-semibold text-red-900 mb-1">Payment Failed</p>
                    <p id="error-message" class="text-red-800"></p>
                </div>
            </div>
        </div>

        <!-- Success Animation (initially hidden) -->
        <div id="success-animation" class="hidden mb-8 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="text-green-800 font-semibold">
                    Payment successful! Redirecting...
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-font-smoothing: antialiased;
        font-size: 16px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }
</style>
@endpush

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Initialize Stripe
    const stripe = Stripe('{{ $stripePublicKey }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');

    let selectedSavedCardId = null;
    let paymentIntentId = '{{ $paymentIntentId }}';

    document.addEventListener('DOMContentLoaded', function() {
        // Mount card element
        cardElement.mount('#card-element');

        // Handle card errors
        cardElement.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Enable submit button when ready
        setTimeout(() => {
            document.getElementById('payment-button').disabled = false;
            document.getElementById('button-text').textContent = 'Pay Ksh {{ number_format($amount, 2) }}';
        }, 500);

        // Handle form submission
        document.getElementById('card-form').addEventListener('submit', handlePayment);
    });

    async function handlePayment(e) {
        e.preventDefault();
        
        const button = document.getElementById('payment-button');
        const statusDiv = document.getElementById('payment-status');
        const errorAlert = document.getElementById('error-alert');
        const errorMessage = document.getElementById('error-message');

        // Show loading state
        button.disabled = true;
        statusDiv.classList.remove('hidden');
        errorAlert.classList.add('hidden');

        try {
            if (selectedSavedCardId) {
                // Use saved card - call server to charge it
                await chargeSavedCard();
            } else {
                // Create new payment method and confirm
                await confirmNewCardPayment();
            }
        } catch (error) {
            console.error('Payment error:', error);
            errorMessage.textContent = error.message || 'Payment failed. Please try again.';
            errorAlert.classList.remove('hidden');
            statusDiv.classList.add('hidden');
            button.disabled = false;
        }
    }

    async function confirmNewCardPayment() {
        const cardholderName = document.getElementById('cardholder-name').value.trim();
        const saveCard = document.getElementById('save-card')?.checked || false;

        if (!cardholderName) {
            throw new Error('Please enter cardholder name');
        }

        // Confirm payment with Stripe
        const { error, paymentIntent } = await stripe.confirmCardPayment(
            '{{ $clientSecret }}',
            {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardholderName,
                    }
                }
            }
        );

        if (error) {
            throw error;
        }

        if (paymentIntent.status === 'succeeded') {
            // Notify backend of successful payment
            await notifyPaymentSuccess(paymentIntentId, saveCard);
        } else {
            throw new Error(`Payment intent status: ${paymentIntent.status}`);
        }
    }

    async function chargeSavedCard() {
        // For saved cards, we would typically:
        // 1. Call server endpoint to confirm payment with saved card
        // 2. Server uses CardPaymentService::confirmPaymentWithCard()
        // For now, show not implemented
        throw new Error('Saved card payment flow will be implemented in next phase');
    }

    async function notifyPaymentSuccess(paymentIntentId, saveCard) {
        const response = await fetch('{{ route("store.payment.stripe.callback") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify({
                payment_intent_id: paymentIntentId,
                order_id: {{ $order->id }},
                save_card: saveCard ? 1 : 0,
            })
        });

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.error || 'Payment verification failed');
        }

        // Show success
        document.getElementById('card-form').classList.add('hidden');
        document.getElementById('payment-status').classList.add('hidden');
        document.getElementById('success-animation').classList.remove('hidden');

        // Redirect after brief delay
        setTimeout(() => {
            window.location.href = result.redirect;
        }, 2000);
    }

    function selectSavedCard(cardId, brand, lastFour) {
        selectedSavedCardId = cardId;
        // Update UI feedback here if needed
    }

    function useSavedCard(cardId) {
        selectedSavedCardId = cardId;
        document.getElementById('card-element').closest('form').querySelector('input[name="payment_method"]').value = `saved_card_${cardId}`;
    }

    function useNewCard() {
        selectedSavedCardId = null;
    }

    // Poll payment status as fallback
    function startStatusPolling() {
        const pollInterval = setInterval(async () => {
            try {
                const response = await fetch(`/api/card/status/${paymentIntentId}`);
                const result = await response.json();

                if (result.status === 'success') {
                    clearInterval(pollInterval);
                    window.location.href = result.order_id ? `/checkout/success/${result.order_id}` : '/';
                } else if (result.status === 'failed') {
                    clearInterval(pollInterval);
                    throw new Error(result.message || 'Payment declined');
                }
            } catch (error) {
                console.error('Status polling error:', error);
            }
        }, 1000);

        // Stop polling after 2 minutes
        setTimeout(() => clearInterval(pollInterval), 120000);
    }
</script>
@endpush
