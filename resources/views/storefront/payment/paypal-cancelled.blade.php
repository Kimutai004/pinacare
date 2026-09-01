@extends('storefront.layouts.app')

@section('content')
<div class="payment-container">
    <div class="payment-card paypal-cancelled">
        <div class="payment-header">
            <h2>Payment Cancelled</h2>
            <p>Your PayPal payment was not completed</p>
        </div>

        <div class="cancellation-icon">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                <circle cx="40" cy="40" r="35" fill="#ffebee" stroke="#d32f2f" stroke-width="2"/>
                <path d="M25 25L55 55M55 25L25 55" stroke="#d32f2f" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>

        <div class="cancellation-message">
            <p class="large-text">Payment was cancelled</p>
            <p class="small-text">You have not been charged. Your order is still saved in your cart.</p>
        </div>

        <div class="order-details">
            <h3>Order Details</h3>
            <div class="detail-row">
                <span class="label">Order ID:</span>
                <span class="value">{{ $order->id ?? 'N/A' }}</span>
            </div>
            @if($order)
            <div class="detail-row">
                <span class="label">Amount:</span>
                <span class="value">${{ number_format($order->total_amount / 100, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value status-pending">Pending Payment</span>
            </div>
            @endif
        </div>

        <div class="what-next">
            <h3>What Next?</h3>
            <ul>
                <li>Your items are still in your cart</li>
                <li>You can return to checkout and try again</li>
                <li>You can use a different payment method</li>
                <li>Your order will not be charged</li>
            </ul>
        </div>

        <div class="payment-actions">
            <a href="{{ route('store.checkout') }}" class="btn btn-primary">Return to Checkout</a>
            <a href="{{ route('storefront.home') }}" class="btn btn-secondary">Continue Shopping</a>
        </div>

        <div class="alert alert-warning">
            <strong>Note:</strong> Your cart items have been preserved. You can complete your purchase at any time.
        </div>
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
    color: #d32f2f;
}

.payment-header p {
    margin: 0;
    color: #666;
    font-size: 14px;
}

.cancellation-icon {
    display: flex;
    justify-content: center;
    margin: 30px 0;
}

.cancellation-message {
    text-align: center;
    margin: 30px 0;
    padding: 20px;
    background: #ffebee;
    border-radius: 8px;
}

.cancellation-message .large-text {
    margin: 0 0 10px 0;
    font-size: 16px;
    font-weight: 600;
    color: #d32f2f;
}

.cancellation-message .small-text {
    margin: 0;
    font-size: 14px;
    color: #c62828;
}

.order-details {
    margin: 30px 0;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.order-details h3 {
    margin: 0 0 15px 0;
    font-size: 14px;
    color: #333;
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

.detail-row .value.status-pending {
    color: #f57c00;
    background: #fff3e0;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.what-next {
    margin: 30px 0;
    padding: 20px;
    background: #e3f2fd;
    border-left: 4px solid #1976d2;
    border-radius: 4px;
}

.what-next h3 {
    margin: 0 0 15px 0;
    font-size: 14px;
    color: #1565c0;
}

.what-next ul {
    margin: 0;
    padding-left: 20px;
    list-style: none;
}

.what-next li {
    margin-bottom: 8px;
    color: #1565c0;
    font-size: 13px;
    position: relative;
    padding-left: 20px;
}

.what-next li:before {
    content: "✓";
    position: absolute;
    left: 0;
    font-weight: bold;
}

.payment-actions {
    display: flex;
    gap: 10px;
    margin: 30px 0;
    flex-direction: column;
}

.btn {
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

.btn-primary:hover {
    background: #5568d3;
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

.alert-warning {
    background: #fff3e0;
    border: 1px solid #ffe0b2;
    color: #e65100;
}

.alert strong {
    font-weight: 600;
}

@media (max-width: 600px) {
    .payment-card {
        padding: 25px;
    }

    .payment-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }
}
</style>
@endsection
