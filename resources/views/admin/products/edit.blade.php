@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-gray-200 shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-lg font-semibold text-gray-900">Edit Product</h1>
                    <p class="text-sm text-gray-500 mt-1">Update the details for this product.</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="shrink-0 inline-flex items-center gap-1 text-sm font-medium text-green-700 hover:text-green-800">
                    <span aria-hidden="true">&larr;</span> Back to Products
                </a>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="px-6 space-y-8">
                <!-- 1. Basic Information -->
                <div>
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Basic Information</h2>
                    <div class="mt-4 border-t border-gray-100 pt-5 grid grid-cols-2 gap-5">
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required placeholder="e.g. Eco Diaper Pack L"
                                   class="w-full px-3 py-2 border border-gray-300 placeholder-gray-400 focus:border-green-600 focus:ring-2 focus:ring-green-600">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select id="category" name="category" class="w-full px-3 py-2 border border-gray-300 bg-white focus:border-green-600 focus:ring-2 focus:ring-green-600">
                                <option value="diaper" {{ $product->category == 'diaper' ? 'selected' : '' }}>Diaper</option>
                                <option value="wipe" {{ $product->category == 'wipe' ? 'selected' : '' }}>Wipe</option>
                                <option value="bundle" {{ $product->category == 'bundle' ? 'selected' : '' }}>Bundle</option>
                            </select>
                        </div>
                        <div>
                            <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                            <select id="size" name="size" class="w-full px-3 py-2 border border-gray-300 bg-white focus:border-green-600 focus:ring-2 focus:ring-green-600">
                                <option value="" {{ $product->size === null || $product->size === '' ? 'selected' : '' }}>None</option>
                                <option value="S" {{ $product->size == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ $product->size == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ $product->size == 'L' ? 'selected' : '' }}>L</option>
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (KES)</label>
                            <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price', $product->price) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600">
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" min="0" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600">
                        </div>
                    </div>
                </div>
                <!-- 2. Product Photo -->
                <div>
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Product Photo</h2>
                    <p class="text-sm text-gray-500 mt-1 mb-5">Leave both fields empty to keep the current photo.</p>
                    <div class="border-t border-gray-100 pt-5 grid grid-cols-2 gap-5">
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Upload a file</label>
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewProductImage(this)"
                                   class="w-full text-sm text-gray-600 file:mr-2 file:py-2 file:px-3 file:border file:border-gray-300 file:text-gray-700 file:hover:bg-gray-50 cursor-pointer">
                        </div>
                        <div>
                            <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">Or paste an image URL</label>
                            <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $product->image_url) }}" placeholder="https://..."
                                   class="w-full px-3 py-2 border border-gray-300 placeholder-gray-400 focus:border-green-600 focus:ring-2 focus:ring-green-600">
                        </div>
                    </div>
                    <div class="mt-5 flex items-center gap-3">
                        <img id="productImagePreview" src="{{ $product->image_url ? asset($product->image_url) : '' }}"
                             alt="Product Photo"
                             class="{{ $product->image_url ? '' : 'hidden' }} w-20 h-20 object-cover border border-gray-200">
                        <p class="text-sm text-gray-500 {{ $product->image_url ? '' : 'hidden' }}" id="currentPhotoLabel">Current photo</p>
                    </div>
                </div>
                <!-- 3. Description & Status -->
                <div>
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Description &amp; Status</h2>
                    <div class="mt-4 border-t border-gray-100 pt-5">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 placeholder-gray-400 focus:border-green-600 focus:ring-2 focus:ring-green-600">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mt-5 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-800">Active</p>
                                <p class="text-sm text-gray-500 mt-0.5">Show this product in the store.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="sr-only peer" {{ $product->is_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer-focus:ring-2 peer-focus:ring-green-600 peer-checked:bg-green-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-green-700 text-white text-sm font-medium hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.previewProductImage = function (input) {
        const preview = document.getElementById('productImagePreview');
        const label = document.getElementById('currentPhotoLabel');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
            label.classList.add('hidden');
        }
    };
</script>
@endpush
