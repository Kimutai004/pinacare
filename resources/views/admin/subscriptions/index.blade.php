@extends('admin.layouts.app')

@section('title', 'Subscriptions')

@section('content')
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <h3 class="font-semibold text-gray-800">Subscriptions</h3>
        <form method="GET" class="flex gap-2">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">All Statuses</option>
                @foreach(['active','paused','cancelled'] as $s)
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
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Frequency</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Next Delivery</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($subscriptions as $sub)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $sub->customer?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $sub->product?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($sub->frequency) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $sub->next_delivery_date ? \Carbon\Carbon::parse($sub->next_delivery_date)->format('d M Y') : '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $sub->status == 'active' ? 'bg-green-100 text-green-700' : ($sub->status == 'paused' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($sub->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.subscriptions.update', $sub) }}" class="flex items-center gap-2">
                                @csrf @method('PUT')
                                <select name="status" class="px-2 py-1 border border-gray-300 rounded-lg text-xs">
                                    @foreach(['active','paused','cancelled'] as $s)
                                        <option value="{{ $s }}" {{ $sub->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                                <input type="date" name="next_delivery_date" value="{{ $sub->next_delivery_date }}" class="px-2 py-1 border border-gray-300 rounded-lg text-xs">
                                <button class="px-2 py-1 bg-green-700 text-white rounded text-xs hover:bg-green-800">Save</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No subscriptions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4">
        {{ $subscriptions->links() }}
    </div>
</div>
@endsection
