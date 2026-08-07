<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Handle M-Pesa payment
    public function mpesa(Request $request)
    {
        // Example: integrate with Safaricom Daraja API here
        $order = Order::findOrFail($request->order_id);

        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'status' => 'success', // update after API confirmation
            'payment_gateway' => 'mpesa',
        ]);

        $order->update(['status' => 'paid']);

        return response()->json(['message' => 'M-Pesa payment successful', 'payment' => $payment]);
    }

    // Handle Stripe payment
    public function stripe(Request $request)
    {
        // Example: integrate with Stripe SDK here
        $order = Order::findOrFail($request->order_id);

        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'status' => 'success', // update after Stripe confirmation
            'payment_gateway' => 'stripe',
        ]);

        $order->update(['status' => 'paid']);

        return response()->json(['message' => 'Stripe payment successful', 'payment' => $payment]);
    }

    // Handle PayPal payment
    public function paypal(Request $request)
    {
        // Example: integrate with PayPal REST API here
        $order = Order::findOrFail($request->order_id);

        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'status' => 'success', // update after PayPal confirmation
            'payment_gateway' => 'paypal',
        ]);

        $order->update(['status' => 'paid']);

        return response()->json(['message' => 'PayPal payment successful', 'payment' => $payment]);
    }

    // Check payment status
    public function status($transaction_id)
    {
        $payment = Payment::where('transaction_id', $transaction_id)->firstOrFail();
        return response()->json($payment);
    }
}
