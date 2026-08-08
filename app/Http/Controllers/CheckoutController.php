<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ImpactMetric;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show checkout page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $total += $product->price * $qty;
            }
        }

        if (empty($cart)) {
            return redirect()->route('store.cart')->with('error', 'Your cart is empty.');
        }

        return view('storefront.checkout', compact('total'));
    }

    /**
     * Place the order (guest checkout + subscription option).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'payment_method' => 'required|in:mpesa,card,paypal',
            'subscribe'      => 'nullable|boolean',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $customer = Customer::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name, 'phone' => $request->phone, 'address' => $request->address]
        );

        $total = 0;
        $items = [];
        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $items[] = ['product' => $product, 'qty' => $qty];
                $total += $product->price * $qty;
            }
        }

        $order = Order::create([
            'customer_id'    => $customer->id,
            'total_amount'   => $total,
            'status'         => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product']->id,
                'quantity'   => $item['qty'],
                'price'      => $item['product']->price,
            ]);

            // Decrement stock
            $item['product']->decrement('stock', $item['qty']);

            // Auto-update impact metrics (diapers saved per diaper unit sold)
            if ($item['product']->category === 'diaper') {
                $metric = ImpactMetric::latest()->first();
                if ($metric) {
                    $metric->increment('diapers_saved', $item['qty']);
                    $metric->increment('co2_reduced', $item['qty'] * 0.25);
                    $metric->increment('farmers_supported', 1);
                }
            }
        }

        // Optional recurring subscription
        if ($request->boolean('subscribe') && count($items) > 0) {
            Subscription::create([
                'customer_id'        => $customer->id,
                'product_id'         => $items[0]['product']->id,
                'frequency'          => 'monthly',
                'next_delivery_date' => now()->addMonth(),
                'status'             => 'active',
            ]);
        }

        // Simulate a payment record
        Payment::create([
            'order_id'        => $order->id,
            'transaction_id'  => strtoupper($request->payment_method).'-'.strtoupper(uniqid()),
            'amount'          => $total,
            'status'          => 'success',
            'payment_gateway' => $request->payment_method === 'card' ? 'stripe' : $request->payment_method,
        ]);

        $order->update(['status' => 'paid']);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('store.checkout.success', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Order confirmation page.
     */
    public function success($id)
    {
        $order = Order::with('customer', 'items.product')->findOrFail($id);

        return view('storefront.checkout-success', compact('order'));
    }
}

