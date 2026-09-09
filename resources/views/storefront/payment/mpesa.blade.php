@extends('storefront.layouts.app')
@section('title', 'M-Pesa Payment')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="payment-container">
    <div class="payment-card mpesa-payment">
        <div class="payment-header">
            <h2>M-Pesa Payment</h2>
            <p>Please enter your M-Pesa PIN on your phone</p>
        </div>

        <div class="payment-status">
            <div class="status-indicator">
                <div class="spinner"></div>
                <p>Waiting for payment confirmation...</p>
            </div>
        </div>

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
                <span class="label">Phone Number:</span>
                <span class="value">{{ $phoneNumber }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Checkout ID:</span>
                <span class="value small">{{ $checkoutRequestId }}</span>
            </div>
        </div>

        <div class="payment-instructions">
            <h4>What to do next:</h4>
            <ol>
                <li>A prompt will appear on your phone</li>
                <li>Enter your M-Pesa PIN</li>
                <li>Wait for confirmation</li>
                <li>You will be redirected to the success page</li>
            </ol>
        </div>

        <div class="payment-actions">
            <a href="{{ route('store.checkout') }}" class="btn btn-secondary">Cancel</a>
            <button id="retry-btn" class="btn btn-primary" style="display: none;">Retry Payment</button>
        </div>

        <div class="alert alert-info">
            <strong>Note:</strong> Do not close this page until you complete the payment. If payment fails, you can retry.
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

.payment-status {
    text-align: center;
    margin: 40px 0;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.status-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e9ecef;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.status-indicator p {
    margin: 0;
    color: #666;
    font-weight: 500;
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

.detail-row .value.small {
    font-size: 12px;
    font-family: monospace;
}

.payment-instructions {
    margin: 30px 0;
    padding: 20px;
    background: #e8f5e9;
    border-left: 4px solid #4caf50;
    border-radius: 4px;
}

.payment-instructions h4 {
    margin: 0 0 15px 0;
    color: #2e7d32;
}

.payment-instructions ol {
    margin: 0;
    padding-left: 20px;
    color: #2e7d32;
}

.payment-instructions li {
    margin-bottom: 8px;
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

.alert-info {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    color: #1565c0;
}

.alert strong {
    font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderId = '{{ $order->id }}';
    const checkoutRequestId = '{{ $checkoutRequestId }}';
    let pollCount = 0;
    const maxPolls = 120; // 2 minutes with 1 second interval
    
    // Start polling for payment status
    const pollInterval = setInterval(function() {
        pollCount++;
        
        fetch(`/api/mpesa/status/${checkoutRequestId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    clearInterval(pollInterval);
                    window.location.href = `{{ route('store.checkout.success', '') }}/${orderId}`;
                } else if (data.status === 'failed') {
                    clearInterval(pollInterval);
                    showPaymentError('Payment failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error checking payment status:', error);
            });
        
        // Stop polling after max attempts
        if (pollCount >= maxPolls) {
            clearInterval(pollInterval);
            showPaymentError('Payment timeout. Please check your M-Pesa for transaction status.');
        }
    }, 1000); // Poll every second
});

function showPaymentError(message) {
    const container = document.querySelector('.payment-card');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-error';
    errorDiv.textContent = message;
    
    const statusDiv = document.querySelector('.payment-status');
    statusDiv.innerHTML = '<p style="color: #d32f2f; font-weight: 500;">Payment Processing Failed</p>';
    
    const retryBtn = document.getElementById('retry-btn');
    retryBtn.style.display = 'block';
    retryBtn.onclick = function() {
        window.location.href = '{{ route('store.checkout') }}';
    };
}
</script>
@endsection
