@extends('storefront.layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 pt-32 pb-12">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Secure Card Payment</h1>
            <p class="text-gray-600 text-lg">Complete your purchase with Stripe's secure payment processing</p>
        </div>

        <!-- Main Grid Layout -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left: Order Summary (Sticky) -->
            <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-green-100 p-8 sticky top-20">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Order Summary
                    </h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Order ID:</span>
                            <span class="font-bold text-gray-800 text-lg">#{{ $order->id }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Items:</span>
                            <span class="font-bold text-gray-800 text-lg">{{ $order->items ? $order->items->count() : 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Subtotal:</span>
                            <span class="font-semibold text-gray-800">Ksh {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 mb-6 border-2 border-green-200">
                    <div class="text-sm text-gray-600 mb-1">Total Amount</div>
                    <div class="text-3xl font-bold text-green-600">Ksh {{ number_format($order->total_amount, 2) }}</div>
                    </div>

                    <!-- Order Items Preview -->
                    @if($order->items && $order->items->count() > 0)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Items in this order:</h3>
                        <div class="space-y-2">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center text-sm py-2">
                                <span class="text-gray-600">{{ $item->product->name ?? 'Product' }} (x{{ $item->quantity }})</span>
                                <span class="font-semibold text-gray-800">Ksh {{ number_format($item->subtotal, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right: Payment Form -->
            <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-green-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10m4 0a1 1 0 11-2 0m2 0a1 1 0 10-2 0m-4-6a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Payment Information
                    </h2>

                    <!-- Saved Cards Option (if available) -->
                    @if($shouldSaveCard && count($savedCards) > 0)
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <label class="block text-gray-700 font-bold mb-4">Use Saved Card</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                            @foreach($savedCards as $card)
                            <div class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-green-400 hover:bg-green-50 cursor-pointer transition"
                                 onclick="selectSavedCard({{ $card->id }}, '{{ $card->card_brand }}', '{{ $card->card_last_four }}')">
                                <input type="radio" name="payment_method" value="saved_card_{{ $card->id }}"
                                       class="mr-3 w-4 h-4" onchange="useSavedCard({{ $card->id }})">
                                <div class="flex-1">
                                    <div class="font-bold text-gray-800">
                                        {{ ucfirst($card->card_brand) }} •••• {{ $card->card_last_four }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Exp {{ $card->card_exp_month }}/{{ $card->card_exp_year }}
                                        @if($card->isExpired())
                                            <span class="text-red-600 font-bold">(Expired)</span>
                                        @endif
                                    </div>
                                </div>
                                @if($card->is_default)
                                <span class="ml-2 px-2 py-1 text-xs font-bold bg-green-100 text-green-800 rounded">Default</span>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <label class="flex items-center text-gray-700 font-medium">
                            <input type="radio" name="payment_method" value="new_card"
                                   class="mr-3 w-4 h-4" checked onchange="useNewCard()">
                            <span>Use a new card instead</span>
                        </label>
                    </div>
                    @endif

                    <!-- New Card Form -->
                    <form id="card-form" class="space-y-6">
                        <!-- Cardholder Name -->
                        <div>
                            <label for="cardholder-name" class="block text-gray-700 font-bold mb-2">
                                Cardholder Name
                            </label>
                            <input type="text" id="cardholder-name" name="cardholder_name"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-gray-800 font-medium"
                                   placeholder="John Doe" required>
                        </div>

                        <!-- Stripe Card Element -->
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Card Details</label>
                            <div id="card-element" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus-within:border-green-500 focus-within:ring-2 focus-within:ring-green-200 transition bg-white"></div>
                            <div id="card-errors" class="text-red-600 text-sm font-semibold mt-2 min-h-5"></div>
                        </div>

                        <!-- Save Card Checkbox (for logged-in users) -->
                        @if($shouldSaveCard)
                        <div class="flex items-center p-4 bg-green-50 rounded-lg border border-green-200">
                            <input type="checkbox" id="save-card" name="save_card" value="1"
                                   class="w-5 h-5 mr-3 rounded accent-green-600">
                            <label for="save-card" class="text-gray-700 font-medium cursor-pointer">
                                Save this card for faster checkout next time
                            </label>
                        </div>
                        @endif

                        <!-- Payment Button -->
                        <button type="submit" id="payment-button"
                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg transition duration-200 flex items-center justify-center gap-2 shadow-lg text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span id="button-text">Processing Payment...</span>
                        </button>
                    </form>

                    <!-- Security Info -->
                    <div class="mt-8 p-5 bg-green-50 border-2 border-green-200 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-bold text-green-900 mb-1">🔒 Secure Payment Guaranteed</p>
                                <p class="text-green-800 text-sm leading-relaxed">Your payment is encrypted and processed securely by Stripe. Your card details are never stored on our servers and are PCI DSS compliant.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Status Indicator -->
        <div id="payment-status" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-8 shadow-2xl">
                <div class="flex flex-col items-center gap-4">
                    <div class="animate-spin">
                        <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 5.293a1 1 0 011.414 0A7 7 0 0016.708 11.5h-2.828a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.172A9 9 0 105.707 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span id="status-message" class="text-gray-700 font-semibold">Processing your payment...</span>
                </div>
            </div>
        </div>

        <!-- Error Alert -->
        <div id="error-alert" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-8 shadow-2xl max-w-md">
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-bold text-red-900 mb-2 text-lg">Payment Failed</p>
                        <p id="error-message" class="text-red-800 mb-4"></p>
                        <button onclick="document.getElementById('error-alert').classList.add('hidden')" class="px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">Try Again</button>
                    </div>
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
    const elements = stripe.elements({
        appearance: {
            theme: 'flat',
            variables: {
                colorPrimary: '#16a34a',
                colorText: '#1f2937',
                borderRadius: '0.5rem',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
            }
        }
    });
    const cardElement = elements.create('card', {
        hidePostalCode: true,
        style: {
            base: {
                fontSize: '16px',
                color: '#1f2937',
                '::placeholder': {
                    color: '#9ca3af',
                },
            }
        }
    });

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

        // Hide payment form and show success
        document.getElementById('payment-status').classList.add('hidden');
        
        // Show success modal
        showSuccessModal(result.redirect);
    }

    function showSuccessModal(redirectUrl) {
        // Create and show success modal
        const modal = document.createElement('div');
        modal.id = 'success-modal';
        modal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl p-8 shadow-2xl text-center max-w-md">
                <div class="mb-6">
                    <svg class="w-16 h-16 text-green-500 mx-auto animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful! 🎉</h2>
                <p class="text-gray-600 mb-6">Your order has been confirmed. Redirecting you...</p>
                <div class="flex justify-center">
                    <svg class="w-6 h-6 animate-spin text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
            </div>
        `;
        document.body.appendChild(modal);

        // Redirect after 2 seconds
        setTimeout(() => {
            window.location.href = redirectUrl;
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
