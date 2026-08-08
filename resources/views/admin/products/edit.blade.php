@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="font-semibold text-gray-800 mb-6">Edit Product</h3>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-4">
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
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Photo</label>
            <input type="file" name="image" accept="image/*" onchange="previewProductImage(this)" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <div class="mt-3">
                <img id="productImagePreview"
                     src="{{ $product->image_url ? asset($product->image_url) : '' }}"
                     alt="Product Photo"
                     class="{{ $product->image_url ? '' : 'hidden' }} w-40 h-40 object-cover rounded-lg border border-gray-200">
            </div>
            <p class="text-xs text-gray-400 mt-1">Upload a new photo to replace the current one.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL (optional, if not uploading)</label>
            <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <p class="text-xs text-gray-400 mt-1">Upload a photo above, or provide an image link here.</p>
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

@push('scripts')
<script>
    window.previewProductImage = function (input) {
        const preview = document.getElementById('productImagePreview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    };
</script>
@endpush
