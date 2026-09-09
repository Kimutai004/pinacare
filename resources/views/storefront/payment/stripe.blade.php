@extends('storefront.layouts.app')
@section('title', 'Card Payment')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="payment-container">
    <div class="payment-card stripe-payment">
        <div class="payment-header">
            <h2>Card Payment</h2>
            <p>Secure payment with Stripe</p>
        </div>

        <form id="payment-form">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="payment_intent_id" value="{{ $paymentIntentId }}">

            <div class="payment-details">
                <div class="detail-row">
                    <span class="label">Order ID:</span>
                    <span class="value">{{ $order->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Amount:</span>
                    <span class="value">KES {{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $customerData['email'] ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="form-section">
                <label for="card-element">Card Details</label>
                <div id="card-element" class="card-element"></div>
                <div id="card-errors" class="error-message"></div>
            </div>

            <div class="form-section">
                <label for="card-holder-name">Cardholder Name</label>
                <input type="text" id="card-holder-name" name="card_holder_name" 
                    value="{{ $customerData['name'] ?? '' }}" required>
            </div>

            <div class="form-section">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                    value="{{ $customerData['email'] ?? '' }}" required>
            </div>

            <div class="form-section">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" 
                    value="{{ $customerData['phone'] ?? '' }}" required>
            </div>

            <div class="payment-actions">
                <a href="{{ route('store.checkout') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" id="submit-btn" class="btn btn-primary">
                    Pay KES {{ number_format($order->total_amount, 2) }}
                </button>
            </div>

            <div class="alert alert-info">
                <strong>Test Cards:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Success: 4242 4242 4242 4242</li>
                    <li>Declined: 4000 0000 0000 0002</li>
                    <li>Any future expiry date and any 3-digit CVC</li>
                </ul>
            </div>
        </form>
    </div>
</div>

<style>
.payment-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
}

.payment-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    padding: 40px;
}

.payment-header {
    text-align: center;
    margin-bottom: 30px;
}

.payment-header h2 {
    margin: 0 0 10px 0;
    color: #333;
}

.payment-header p {
    margin: 0;
    color: #666;
    font-size: 14px;
}

.payment-details {
    margin: 30px 0;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 14px;
}

.detail-row:last-child {
    margin-bottom: 0;
}

.detail-row .label {
    color: #666;
    font-weight: 500;
}

.detail-row .value {
    color: #333;
    font-weight: 600;
}

.form-section {
    margin: 20px 0;
}

.form-section label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
    font-size: 14px;
}

.form-section input[type="text"],
.form-section input[type="email"],
.form-section input[type="tel"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

.form-section input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.card-element {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: white;
}

.StripeElement--focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.StripeElement--invalid {
    border-color: #fa755a;
}

.error-message {
    color: #fa755a;
    font-size: 13px;
    margin-top: 8px;
    min-height: 16px;
}

.payment-actions {
    display: flex;
    gap: 10px;
    margin: 30px 0;
}

.btn {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background: #5568d3;
}

.btn-primary:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.btn-secondary {
    background: #e9ecef;
    color: #333;
}

.btn-secondary:hover {
    background: #dee2e6;
}

.alert {
    padding: 15px;
    border-radius: 6px;
    font-size: 13px;
    margin: 20px 0 0 0;
}

.alert-info {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    color: #1565c0;
}

.alert ul {
    list-style: none;
}

.alert li {
    font-family: monospace;
    font-size: 12px;
}

.alert strong {
    font-weight: 600;
}
</style>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stripe = Stripe('{{ $stripePublicKey }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    const submitBtn = document.getElementById('submit-btn');
    const cardErrors = document.getElementById('card-errors');

    // Handle real-time validation errors
    cardElement.addEventListener('change', function(event) {
        if (event.error) {
            cardErrors.textContent = event.error.message;
        } else {
            cardErrors.textContent = '';
        }
    });

    // Handle form submission
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';

        const clientSecret = '{{ $clientSecret }}';
        
        // Confirm card payment
        const result = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: {
                    name: document.getElementById('card-holder-name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                }
            }
        });

        if (result.error) {
            cardErrors.textContent = result.error.message;
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pay KES {{ number_format($order->total_amount, 2) }}';
        } else if (result.paymentIntent.status === 'succeeded') {
            // Payment succeeded, verify with backend
            verifyPaymentWithBackend(result.paymentIntent.id);
        } else {
            cardErrors.textContent = 'Payment status: ' + result.paymentIntent.status;
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pay KES {{ number_format($order->total_amount, 2) }}';
        }
    });

    function verifyPaymentWithBackend(paymentIntentId) {
        fetch('{{ route('store.payment.stripe.callback') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: JSON.stringify({
                payment_intent_id: paymentIntentId,
                order_id: '{{ $order->id }}'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `{{ route('store.checkout.success', '') }}/${data.order_id}`;
            } else {
                cardErrors.textContent = data.message || 'Payment verification failed';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Pay KES {{ number_format($order->total_amount, 2) }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            cardErrors.textContent = 'An error occurred. Please try again.';
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pay KES {{ number_format($order->total_amount, 2) }}';
        });
    }
});
</script>
@endsection
