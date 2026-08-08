<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('customer','items')
            ->when($request->has('status') && $request->status !== '', fn($q) => $q->where('status',$request->status))
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('customer','items.product','payment');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
        ]);

        $order->update($data);

        return back()->with('success','Order status updated to '.$order->status.'.');
    }

    public function addPayment(Request $request, Order $order)
    {
        $data = $request->validate([
            'transaction_id' => 'required|string|max:100',
            'amount'         => 'required|numeric|min:0',
            'status'         => 'required|in:success,failed,pending',
            'payment_gateway'=> 'required|in:mpesa,stripe,paypal',
        ]);

        Payment::create(array_merge($data, ['order_id' => $order->id]));

        if ($data['status'] === 'success') {
            $order->update(['status' => 'paid']);
        }

        return back()->with('success','Payment recorded successfully.');
    }
}
