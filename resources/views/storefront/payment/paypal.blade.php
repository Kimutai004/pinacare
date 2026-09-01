@extends('storefront.layouts.app')

@section('content')
<div class="payment-container">
    <div class="payment-card paypal-payment">
        <div class="payment-header">
            <h2>PayPal Payment</h2>
            <p>Complete your purchase securely with PayPal</p>
        </div>

        <div class="payment-details">
            <div class="detail-row">
                <span class="label">Order ID:</span>
                <span class="value">{{ $order->id }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Amount:</span>
                <span class="value">${{ number_format($order->total_amount / 100, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Currency:</span>
                <span class="value">{{ $currency ?? 'USD' }}</span>
            </div>
        </div>

        <div class="payment-info">
            <p>You will be redirected to PayPal to complete your payment securely.</p>
        </div>

        <div class="payment-actions">
            <a href="{{ route('store.checkout') }}" class="btn btn-secondary">Cancel</a>
            <a href="{{ $approvalUrl }}" class="btn btn-paypal">
                <span class="paypal-logo">Pay with</span> PayPal
            </a>
        </div>

        <div class="alert alert-info">
            <strong>Note:</strong> You will be redirected to PayPal's secure website. After completing the payment, 
            you will be returned to confirm your order.
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

.payment-info {
    margin: 30px 0;
    padding: 20px;
    background: #e8f5e9;
    border-left: 4px solid #4caf50;
    border-radius: 4px;
    text-align: center;
}

.payment-info p {
    margin: 0;
    color: #2e7d32;
    font-size: 14px;
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
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background: #5568d3;
}

.btn-secondary {
    background: #e9ecef;
    color: #333;
}

.btn-secondary:hover {
    background: #dee2e6;
}

.btn-paypal {
    background: #0070ba;
    color: white;
    font-weight: 700;
    font-size: 15px;
}

.btn-paypal:hover {
    background: #005ea6;
}

.paypal-logo {
    font-style: italic;
    font-size: 11px;
    font-weight: 400;
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

.alert strong {
    font-weight: 600;
}
</style>
@endsection
