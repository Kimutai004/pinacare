@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="space-y-6">
    <!-- Eco header -->
    <div class="relative overflow-hidden rounded-2xl bg-green-700 text-white p-6 shadow-lg">
        <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-white/10"></div>
        <div class="relative flex items-center gap-3">
            <div class="w-11 h-11 rounded-full bg-white/15 flex items-center justify-center">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-lime-300">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Product Catalog</h1>
                <p class="text-green-100 text-sm">Eco-friendly, baby-safe products built on a circular economy.</p>
            </div>
        </div>
    </div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <h3 class="font-semibold text-gray-800">Products</h3>
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">All Categories</option>
                    <option value="diaper" {{ request('category') == 'diaper' ? 'selected' : '' }}>Diaper</option>
                    <option value="wipe" {{ request('category') == 'wipe' ? 'selected' : '' }}>Wipe</option>
                    <option value="bundle" {{ request('category') == 'bundle' ? 'selected' : '' }}>Bundle</option>
                </select>
                <button class="px-3 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Filter</button>
            </form>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm text-center hover:bg-green-800">+ Add Product</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
<th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Size</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr>
<td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->image_url)
                                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-11 h-11 rounded-lg object-cover border border-gray-200">
                                @else
                                    <span class="w-11 h-11 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-sm font-bold">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                @endif
                                <span class="text-sm text-gray-700">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($product->category) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $product->size ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">KES {{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->stock == 0 ? 'bg-red-100 text-red-700' : ($product->stock < 10 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-xs text-blue-600 hover:text-blue-800">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4">
        {{ $products->links() }}
    </div>
</div>
</div>
@endsection
