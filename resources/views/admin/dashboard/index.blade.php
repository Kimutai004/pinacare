@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalOrders) }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg text-2xl">🛒</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Revenue</p>
                    <p class="text-2xl font-bold text-gray-800">KES {{ number_format($revenue, 2) }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg text-2xl">💰</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active Subscriptions</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($activeSubs) }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg text-2xl">🔁</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Low Stock Alerts</p>
                    <p class="text-2xl font-bold {{ $lowStockAlerts > 0 ? 'text-red-600' : 'text-gray-800' }}">{{ number_format($lowStockAlerts) }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg text-2xl">⚠️</div>
            </div>
        </div>
    </div>

    <!-- Recent Orders + Payment Pie -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-green-700 hover:text-green-900">View All →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-700">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $order->customer?->name ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $order->status == 'delivered' ? 'bg-green-100 text-green-700' : ($order->status == 'cancelled' ? 'bg-red-100 text-red-700' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">KES {{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Pie Chart -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Payment Overview</h3>
            <canvas id="paymentChart" height="220"></canvas>
            <div class="mt-4 space-y-2 text-sm">
                @php
                    $labels = ['mpesa' => 'M-Pesa', 'stripe' => 'Card', 'paypal' => 'PayPal'];
                    $colors = ['mpesa' => '#10B981', 'stripe' => '#3B82F6', 'paypal' => '#F59E0B'];
                @endphp
                @foreach($labels as $key => $label)
                    <div class="flex items-center justify-between">
                        <span class="flex items-center">
                            <span class="inline-block w-3 h-3 rounded-full mr-2" style="background: {{ $colors[$key] }}"></span>
                            {{ $label }}
                        </span>
                        @if(isset($payments[$key]))
                            <span class="font-medium">KES {{ number_format($payments[$key], 2) }}</span>
                        @else
                            <span class="text-gray-400">KES 0.00</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Inventory Alerts + Impact Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-800">Inventory Alerts</h3>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($inventoryAlerts as $product)
                    <li class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->category }} · {{ $product->size ?? 'N/A' }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $product->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $product->stock == 0 ? 'Out of stock' : $product->stock.' left' }}
                        </span>
                    </li>
                @empty
                    <li class="px-6 py-4 text-sm text-gray-500">All products well stocked.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Impact Metrics</h3>
            @if($impactMetrics)
                <div class="space-y-4">
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-sm text-green-700">Diapers Saved</p>
                        <p class="text-3xl font-bold text-green-800">{{ number_format($impactMetrics->diapers_saved) }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-700">CO₂ Reduced (kg)</p>
                        <p class="text-3xl font-bold text-blue-800">{{ number_format($impactMetrics->co2_reduced, 1) }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-lg p-4">
                        <p class="text-sm text-amber-700">Farmers Supported</p>
                        <p class="text-3xl font-bold text-amber-800">{{ number_format($impactMetrics->farmers_supported) }}</p>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500">No impact data yet.</p>
            @endif
            <a href="{{ route('admin.impact.index') }}" class="inline-block mt-4 text-sm text-green-700 hover:text-green-900">Manage →</a>
        </div>

        <!-- Testimonials recent -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Pending Testimonials</h3>
            <div class="space-y-4">
                @forelse($testimonials as $t)
                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-700">"{{ \Illuminate\Support\Str::limit($t->content, 80) }}"</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-xs text-gray-500">{{ $t->customer?->name ?? 'Customer' }} · {{ $t->rating }}★</span>
                            <form method="POST" action="{{ route('admin.testimonials.approve', $t) }}">
                                @csrf @method('PUT')
                                <button class="text-xs bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Approve</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No pending testimonials.</p>
                @endforelse
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="inline-block mt-4 text-sm text-green-700 hover:text-green-900">View All →</a>
        </div>
    </div>

    <!-- Blog Posts -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Latest Blog Posts</h3>
            <a href="{{ route('admin.blog.create') }}" class="text-sm bg-green-700 text-white px-3 py-1.5 rounded hover:bg-green-800">+ New Post</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($blogPosts as $post)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $post->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $post->author?->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $post->published_at ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $post->published_at ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.blog.edit', $post) }}" class="text-xs text-blue-600 hover:text-blue-800">Edit</a>
                                @if($post->published_at)
                                    <form method="POST" action="{{ route('admin.blog.unpublish', $post) }}" class="inline">
                                        @csrf @method('PUT')
                                        <button class="text-xs text-yellow-600 hover:text-yellow-800">Unpublish</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.blog.publish', $post) }}" class="inline">
                                        @csrf @method('PUT')
                                        <button class="text-xs text-green-600 hover:text-green-800">Publish</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No blog posts yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@php
    $paymentData = [
        $payments['mpesa'] ?? 0,
        $payments['stripe'] ?? 0,
        $payments['paypal'] ?? 0,
    ];
@endphp
@push('scripts')
<script>
    const ctx = document.getElementById('paymentChart').getContext('2d');
    const labels = @json(['mpesa','stripe','paypal']);
    const data = {!! json_encode($paymentData) !!};
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['M-Pesa', 'Card', 'PayPal'],
            datasets: [{
                data: data,
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B'],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
