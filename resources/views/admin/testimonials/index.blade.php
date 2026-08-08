@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Testimonials</h3>
        <form method="GET" class="flex gap-2">
            <select name="filter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">All</option>
                <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('filter') == 'approved' ? 'selected' : '' }}>Approved</option>
            </select>
            <button class="px-3 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Filter</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Review</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($testimonials as $t)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $t->customer?->name ?? 'Customer' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 max-w-md">{{ \Illuminate\Support\Str::limit($t->content, 100) }}</td>
                        <td class="px-6 py-4 text-sm text-yellow-500">{{ str_repeat('★', $t->rating) }}{{ str_repeat('☆', 5 - $t->rating) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $t->approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $t->approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            @if(!$t->approved)
                                <form method="POST" action="{{ route('admin.testimonials.approve', $t) }}" class="inline">
                                    @csrf @method('PUT')
                                    <button class="text-xs bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Approve</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.testimonials.reject', $t) }}" class="inline">
                                    @csrf @method('PUT')
                                    <button class="text-xs bg-yellow-600 text-white px-2 py-1 rounded hover:bg-yellow-700">Unapprove</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" class="inline" onsubmit="return confirm('Delete this testimonial?')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No testimonials found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4">
        {{ $testimonials->links() }}
    </div>
</div>
@endsection
