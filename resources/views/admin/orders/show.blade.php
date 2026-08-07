@extends('admin.layouts.app')

@section('title', 'Order #'.$order->id)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-xl font-semibold text-gray-800">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-800">← Back to Orders</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer + Status -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h4 class="font-semibold text-gray-800 mb-4">Order Details</h4>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Customer</p>
                    <p class="font-medium text-gray-800">{{ $order->customer?->name ?? '—' }}</p>
                    <p class="text-sm text-gray-500">{{ $order->customer?->email }}</p>
                    <p class="text-sm text-gray-500">{{ $order->customer?->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Payment Method</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($order->payment_method) }}</p>
                    <p class="text-sm text-gray-500">Total: <span class="font-medium">KES {{ number_format($order->total_amount, 2) }}</span></p>
                </div>
            </div>

            <!-- Update Status -->
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex items-end gap-3 border-t pt-4">
                @csrf @method('PUT')
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @foreach(['pending','paid','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Update</button>
            </form>
        </div>

        <!-- Payment record -->
        <div class="bg-white rounded-xl shadow p-6">
            <h4 class="font-semibold text-gray-800 mb-4">Payment</h4>
            @if($order->payment)
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-500">Transaction:</span> {{ $order->payment->transaction_id }}</p>
                    <p><span class="text-gray-500">Gateway:</span> {{ ucfirst($order->payment->payment_gateway) }}</p>
                    <p><span class="text-gray-500">Amount:</span> KES {{ number_format($order->payment->amount, 2) }}</p>
                    <p><span class="text-gray-500">Status:</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $order->payment->status == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </p>
                </div>
            @else
                <p class="text-sm text-gray-500 mb-4">No payment recorded yet.</p>
                <form method="POST" action="{{ route('admin.orders.payment', $order) }}" class="space-y-3">
                    @csrf
                    <input type="text" name="transaction_id" placeholder="Transaction ID" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <input type="number" step="0.01" name="amount" placeholder="Amount" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <select name="payment_gateway" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="mpesa">M-Pesa</option>
                        <option value="stripe">Card</option>
                        <option value="paypal">PayPal</option>
                    </select>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="success">Success</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                    <button class="w-full px-4 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Record Payment</button>
                </form>
            @endif
        </div>
    </div>

    <!-- Items -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h4 class="font-semibold text-gray-800">Order Items</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Qty</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->product?->name ?? 'Product #'.$item->product_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">KES {{ number_format($item->price, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">KES {{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
