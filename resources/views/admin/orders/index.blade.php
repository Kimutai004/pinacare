@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <h3 class="font-semibold text-gray-800">Orders</h3>
        <form method="GET" class="flex gap-2">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">All Statuses</option>
                @foreach(['pending','paid','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Filter</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->customer?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($order->payment_method) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-700' : ($order->status == 'cancelled' ? 'bg-red-100 text-red-700' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">KES {{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-xs text-blue-600 hover:text-blue-800">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
