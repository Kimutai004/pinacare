@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="font-semibold text-gray-800 mb-6">Edit Product</h3>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="diaper" {{ $product->category == 'diaper' ? 'selected' : '' }}>Diaper</option>
                    <option value="wipe" {{ $product->category == 'wipe' ? 'selected' : '' }}>Wipe</option>
                    <option value="bundle" {{ $product->category == 'bundle' ? 'selected' : '' }}>Bundle</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                <select name="size" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">None</option>
                    <option value="S" {{ $product->size == 'S' ? 'selected' : '' }}>S</option>
                    <option value="M" {{ $product->size == 'M' ? 'selected' : '' }}>M</option>
                    <option value="L" {{ $product->size == 'L' ? 'selected' : '' }}>L</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (KES)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
            <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
            <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm hover:bg-green-800">Update Product</button>
        </div>
    </form>
</div>
@endsection
