@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-gray-800">Customers</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Orders</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Subscriptions</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($customers as $customer)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $customer->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $customer->email ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $customer->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $customer->orders_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $customer->subscriptions_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $customer->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No customers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4">
        {{ $customers->links() }}
    </div>
</div>
@endsection
