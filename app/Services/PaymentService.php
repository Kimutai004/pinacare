<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ImpactMetric;
use Illuminate\Support\Facades\DB;

/**
 * Central payment service to handle payment processing and order fulfillment
 */
class PaymentService
{
    /**
     * Process payment initiation based on payment method
     */
    public function initiatePayment(Order $order, string $paymentMethod)
    {
        return match($paymentMethod) {
            'mpesa' => new MpesaPaymentService(),
            'card' => new StripePaymentService(),
            'paypal' => new PayPalPaymentService(),
            default => throw new \Exception('Unsupported payment method: ' . $paymentMethod),
        };
    }

    /**
     * Verify and complete payment - called after payment gateway confirms
     * This is the critical function that:
     * 1. Verifies payment success
     * 2. Deducts stock
     * 3. Updates order status
     * 4. Updates impact metrics
     */
    public function confirmPayment(Order $order, array $paymentData): bool
    {
        return DB::transaction(function () use ($order, $paymentData) {
            // Verify payment status
            if ($paymentData['status'] !== 'success') {
                $order->update(['status' => 'payment_failed']);
                return false;
            }

            // Create/update payment record
            $payment = Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_id' => $paymentData['transaction_id'],
                    'amount' => $paymentData['amount'],
                    'status' => 'success',
                    'payment_gateway' => $paymentData['payment_gateway'],
                ]
            );

            // Deduct stock for each order item
            foreach ($order->items as $item) {
                $product = $item->product;
                
                // Check if stock is available
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                // Deduct stock
                $product->decrement('stock', $item->quantity);

                // Update impact metrics if it's a diaper product
                if ($product->category === 'diaper') {
                    $metric = ImpactMetric::latest()->first();
                    if ($metric) {
                        $metric->increment('diapers_saved', $item->quantity);
                        $metric->increment('co2_reduced', $item->quantity * 0.25);
                        $metric->increment('farmers_supported', 1);
                    }
                }
            }

            // Update order status to paid
            $order->update(['status' => 'paid']);

            return true;
        });
    }

    /**
     * Handle failed payment - restore order to pending state
     */
    public function handlePaymentFailure(Order $order, string $reason): void
    {
        DB::transaction(function () use ($order, $reason) {
            $order->update([
                'status' => 'payment_failed',
                'payment_notes' => $reason,
            ]);

            // Create failed payment record for audit
            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => 'FAILED-' . uniqid(),
                'amount' => $order->total_amount,
                'status' => 'failed',
                'payment_gateway' => $order->payment_method,
            ]);
        });
    }

    /**
     * Refund a paid order - reverse stock and updates
     */
    public function refundOrder(Order $order): bool
    {
        return DB::transaction(function () use ($order) {
            if ($order->status !== 'paid') {
                throw new \Exception('Can only refund paid orders');
            }

            // Restore stock
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);

                // Reverse impact metrics
                if ($item->product->category === 'diaper') {
                    $metric = ImpactMetric::latest()->first();
                    if ($metric) {
                        $metric->decrement('diapers_saved', $item->quantity);
                        $metric->decrement('co2_reduced', $item->quantity * 0.25);
                        $metric->decrement('farmers_supported', 1);
                    }
                }
            }

            // Mark payment as refunded
            if ($order->payment) {
                $order->payment->update(['status' => 'refunded']);
            }

            // Update order status
            $order->update(['status' => 'refunded']);

            return true;
        });
    }
}
