<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Create or find customer
        $customer = Customer::firstOrCreate(
            ['email' => $request->email],
            $request->only(['name','phone','address'])
        );

        // Create order
        $order = Order::create([
            'customer_id' => $customer->id,
            'total_amount' => $request->total_amount,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Add items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json($order->load('items'), 201);
    }

    public function index()
    {
        // Admin only
        return response()->json(Order::with('customer','items')->get());
    }
}
