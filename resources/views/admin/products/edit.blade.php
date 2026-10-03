@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="space-y-6">

    {{-- ================= Eco header ================= --}}
    <div class="relative overflow-hidden rounded-2xl bg-green-700 text-white p-6 shadow-lg">
        <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-white/10"></div>
        <div class="absolute -left-6 -bottom-10 w-28 h-28 rounded-full bg-lime-300/10"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4 min-w-0">
                <div class="w-11 h-11 shrink-0 rounded-full bg-white/15 flex items-center justify-center">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-lime-300">
                        <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1 text-xs font-medium text-green-100 hover:text-white transition-colors">
                        <span aria-hidden="true">&larr;</span> Products
                    </a>
                    <h1 class="text-2xl font-bold truncate">{{ $product->name }}</h1>
                    <p class="text-green-100 text-sm">Update the details customers see for this product.</p>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0 flex-wrap">
                <span id="headerStatusBadge" class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-lime-300 text-green-900' : 'bg-white/20 text-white' }}">
                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                </span>
                <a href="{{ route('store.product', $product) }}" target="_blank" rel="noopener"
                   class="px-3 py-1.5 rounded-full text-xs font-semibold bg-white/15 text-white hover:bg-white/25 transition-colors inline-flex items-center gap-1.5">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5">
                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/>
                    </svg>
                    View in store
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" id="productForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- ================= Main column ================= --}}
            <div class="lg:col-span-2 space-y-6">

{{-- Inline validation summary --}}
                @if($errors->any())
                    <div class="rounded-xl bg-red-50 border border-red-200 p-4" role="alert">
                        <div class="flex items-start gap-3">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-red-600 shrink-0 mt-0.5">
                                <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800">Please fix the following</h3>
                                <ul class="mt-1.5 space-y-0.5 text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ---- 1. Basic Information ---- --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-green-50 text-green-700 flex items-center justify-center shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-semibold text-gray-800">Basic Information</h2>
                            <p class="text-xs text-gray-500">How this product is identified in the catalogue.</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required placeholder="e.g. Eco Diaper Pack L"
                                   class="w-full px-3 py-2.5 rounded-lg border placeholder-gray-400 focus:border-green-600 focus:ring-2 focus:ring-green-600 @error('name') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                                <select id="category" name="category" class="w-full px-3 py-2.5 rounded-lg border bg-white focus:border-green-600 focus:ring-2 focus:ring-green-600 @error('category') border-red-400 @enderror">
                                    <option value="diaper" {{ $product->category == 'diaper' ? 'selected' : '' }}>Diaper</option>
                                    <option value="wipe" {{ $product->category == 'wipe' ? 'selected' : '' }}>Wipe</option>
                                    <option value="bundle" {{ $product->category == 'bundle' ? 'selected' : '' }}>Bundle</option>
                                </select>
                                @error('category') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="size" class="block text-sm font-medium text-gray-700 mb-1.5">Size</label>
                                <select id="size" name="size" class="w-full px-3 py-2.5 rounded-lg border bg-white focus:border-green-600 focus:ring-2 focus:ring-green-600">
                                    <option value="" {{ $product->size === null || $product->size === '' ? 'selected' : '' }}>None</option>
                                    <option value="S" {{ $product->size == 'S' ? 'selected' : '' }}>S</option>
                                    <option value="M" {{ $product->size == 'M' ? 'selected' : '' }}>M</option>
                                    <option value="L" {{ $product->size == 'L' ? 'selected' : '' }}>L</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
{{-- ---- 2. Pricing & Inventory ---- --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-green-50 text-green-700 flex items-center justify-center shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-semibold text-gray-800">Pricing &amp; Inventory</h2>
                            <p class="text-xs text-gray-500">Set the selling price and how many units are on hand.</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1.5">Price (KES) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 pointer-events-none">KES</span>
                                    <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price', $product->price) }}" required
                                           class="w-full pl-14 px-3 py-2.5 rounded-lg border focus:border-green-600 focus:ring-2 focus:ring-green-600 @error('price') border-red-400 @enderror">
                                </div>
                                @error('price') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1.5">Stock <span class="text-red-500">*</span></label>
                                <input type="number" min="0" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required
                                       class="w-full px-3 py-2.5 rounded-lg border focus:border-green-600 focus:ring-2 focus:ring-green-600 @error('stock') border-red-400 @enderror">
                                @error('stock') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                                <p id="stockHint" class="mt-1.5 text-xs text-gray-500"></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4 rounded-lg bg-gray-50 px-4 py-3">
                            <span class="text-sm text-gray-600">Inventory value at this price</span>
                            <span class="text-sm font-semibold text-gray-900" id="inventoryValue">KES 0.00</span>
                        </div>
                    </div>
                </div>
{{-- ---- 3. Description ---- --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-green-50 text-green-700 flex items-center justify-center shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-semibold text-gray-800">Description</h2>
                            <p class="text-xs text-gray-500">Shown on the product page and used for SEO.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                        <textarea id="description" name="description" rows="5"
                                  placeholder="Describe the product, materials and why parents will love it..."
                                  class="w-full px-3 py-2.5 rounded-lg border placeholder-gray-400 focus:border-green-600 focus:ring-2 focus:ring-green-600">{{ old('description', $product->description) }}</textarea>
                        <div class="mt-1.5 flex items-center justify-between gap-3">
                            @error('description') <p class="text-xs text-red-600">{{ $message }}</p> @else <span></span> @enderror
                            <span class="text-xs text-gray-400"><span id="descCount">0</span> characters</span>
                        </div>
                    </div>
                </div>
{{-- ---- 4. Visibility ---- --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-green-50 text-green-700 flex items-center justify-center shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-semibold text-gray-800">Visibility</h2>
                            <p class="text-xs text-gray-500">Control whether shoppers can see this product.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-800">Active</p>
                                <p class="text-xs text-gray-500 mt-0.5">Show this product in the store.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="sr-only peer" {{ $product->is_active ? 'checked' : '' }}>
                                <div class="w-12 h-7 bg-gray-300 rounded-full peer-focus:ring-4 peer-focus:ring-green-200 peer-checked:bg-green-600 after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:shadow after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                    </div>
                </div>
{{-- ---- Sticky action bar ---- --}}
                <div class="sticky bottom-4 bg-white/95 backdrop-blur rounded-xl shadow-lg border border-gray-200 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p id="unsavedNotice" class="hidden items-center gap-2 text-sm text-amber-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                            <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
                        </svg>
                        You have unsaved changes.
                    </p>
                    <span id="savedState" class="text-sm text-gray-500">All changes are saved.</span>

                    <div class="flex items-center gap-3 sm:ml-auto">
                        <a href="{{ route('admin.products.index') }}"
                           class="flex-1 sm:flex-none text-center px-4 py-2.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" id="submitBtn"
                                class="flex-1 sm:flex-none text-center px-5 py-2.5 rounded-lg bg-green-700 text-white text-sm font-medium hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 transition-colors inline-flex items-center justify-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/>
                            </svg>
                            Update Product
                        </button>
                    </div>
                </div>
            </div>

            {{-- ================= Sidebar column ================= --}}
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-6">
{{-- ---- Product Photo ---- --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-green-50 text-green-700 flex items-center justify-center shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-semibold text-gray-800">Product Photo</h2>
                            <p class="text-xs text-gray-500">Your saved photo stays unless you choose a new file.</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="relative aspect-square w-full rounded-lg bg-green-50 border border-gray-200 overflow-hidden flex items-center justify-center">
                            <img id="productImagePreview"
                                 src="{{ $product->image_url ? asset($product->image_url) : '' }}"
                                 data-original-src="{{ $product->image_url ? asset($product->image_url) : '' }}"
                                 alt="{{ $product->name }}"
                                 class="{{ $product->image_url ? '' : 'hidden' }} w-full h-full object-cover">

                            <div id="photoEmptyState" class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 {{ $product->image_url ? 'hidden' : '' }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-green-400 mb-3">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-700">No photo yet</p>
                                <p class="text-xs text-gray-400 mt-1">Products with a photo sell better.</p>
                            </div>

                            <span id="photoBadge" class="absolute top-2 left-2 px-2.5 py-1 rounded-full text-xs font-semibold {{ $product->image_url ? 'bg-green-700 text-white' : 'hidden' }}">
                                Current photo
                            </span>
                        </div>

                        {{-- Wrapper handles drag & drop; the native input stays visible
                             so the browser file dialog is always reachable. --}}
                        <div id="dropZone"
                             class="w-full rounded-lg border-2 border-dashed border-gray-300 text-center transition-colors hover:border-green-500 hover:bg-green-50/40">
                            <input type="file"
                                   id="image"
                                   name="image"
                                   accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp"
                                   onchange="previewProductImage(this)"
                                   class="block w-full text-sm text-gray-600 cursor-pointer
                                          file:mr-4 file:py-4 file:px-4 file:border-0 file:bg-transparent
                                          file:text-sm file:font-semibold file:text-green-700
                                          file:cursor-pointer hover:file:bg-green-50">
                        </div>

                        <p id="fileMeta" class="hidden items-center gap-1.5 text-xs text-gray-500">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0 text-gray-400">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/>
                            </svg>
                            <span id="fileMetaText"></span>
                        </p>

                        @error('image')
                            <p class="flex items-start gap-1.5 text-xs text-red-600">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0 mt-0.5">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror

                        <p class="text-xs text-gray-500 flex items-start gap-1.5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0 mt-0.5 text-gray-400">
                                <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                            </svg>
                            <span id="currentPhotoHelp">Leaving this empty keeps the photo that is already saved.</span>
                        </p>
                    </div>
                </div>
{{-- ---- Store preview summary ---- --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-800">Store Preview</h2>
                        <p class="text-xs text-gray-500">What shoppers will see.</p>
                    </div>
                    <div class="p-6 space-y-3 text-sm">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Name</p>
                            <p class="text-gray-800 font-medium break-words" id="previewName">{{ $product->name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Price</p>
                                <p class="text-gray-800 font-medium" id="previewPrice">KES {{ number_format($product->price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Availability</p>
                                <p class="text-gray-800 font-medium" id="previewStock">{{ $product->stock > 0 ? $product->stock.' in stock' : 'Out of stock' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700" id="previewCategory">{{ ucfirst($product->category) }}</span>
                            @if($product->size)
                                <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-700">Size {{ $product->size }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---------- Photo preview ---------- */
    const preview    = document.getElementById('productImagePreview');
    const badge      = document.getElementById('photoBadge');
    const emptyState = document.getElementById('photoEmptyState');
    const helpText   = document.getElementById('currentPhotoHelp');
    const input      = document.getElementById('image');
    const dropZone   = document.getElementById('dropZone');

    const originalSrc = preview ? (preview.dataset.originalSrc || '') : '';
    const fileMeta    = document.getElementById('fileMeta');
    const fileMetaText= document.getElementById('fileMetaText');

    function humanSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(0) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function showFileMeta(file) {
        if (!fileMeta || !fileMetaText) return;
        fileMetaText.textContent = file.name + ' — ' + humanSize(file.size);
        fileMeta.classList.remove('hidden');
        fileMeta.classList.add('flex');
    }

    function clearFileMeta() {
        if (!fileMeta) return;
        fileMeta.classList.add('hidden');
        fileMeta.classList.remove('flex');
    }

    function showPhoto(src, isNew) {
        if (!preview) return;

        // Revoke the previous object URL so we don't leak memory.
        if (preview.dataset.objectUrl) {
            URL.revokeObjectURL(preview.dataset.objectUrl);
            delete preview.dataset.objectUrl;
        }

        preview.src = src;
        preview.classList.remove('hidden');
        if (emptyState) emptyState.classList.add('hidden');

        if (badge) {
            badge.textContent = isNew ? 'New photo' : 'Current photo';
            badge.classList.toggle('bg-amber-500', !! isNew);
            badge.classList.toggle('bg-green-700', ! isNew);
            badge.classList.remove('hidden');
        }

        if (helpText) {
            helpText.textContent = isNew
                ? 'This will replace your saved photo when you update the product.'
                : 'Leaving this empty keeps the photo that is already saved.';
        }
    }

    function resetPhoto() {
        if (!preview) return;

        if (preview.dataset.objectUrl) {
            URL.revokeObjectURL(preview.dataset.objectUrl);
            delete preview.dataset.objectUrl;
        }

        preview.src = originalSrc;
        preview.classList.toggle('hidden', ! originalSrc);
        if (emptyState) emptyState.classList.toggle('hidden', !! originalSrc);

        if (badge) {
            badge.textContent = 'Current photo';
            badge.classList.remove('hidden');
            badge.classList.toggle('bg-amber-500', false);
            badge.classList.toggle('bg-green-700', true);
            badge.classList.toggle('hidden', ! originalSrc);
        }

        if (helpText) {
            helpText.textContent = 'Leaving this empty keeps the photo that is already saved.';
        }
    }

    // Exposed for the inline onchange handler.
    window.previewProductImage = function (fileInput) {
        const file = fileInput.files && fileInput.files[0];

        if (file) {
            showPhoto(URL.createObjectURL(file), true);
            preview.dataset.objectUrl = preview.src;
            showFileMeta(file);
        } else {
            // File input was cleared - restore the photo that is already saved.
            resetPhoto();
            clearFileMeta();
        }
    };

    /* ---------- Drag & drop ---------- */
    if (dropZone && input) {
        ['dragenter', 'dragover'].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault();
                dropZone.classList.add('border-green-500', 'bg-green-50');
            });
        });

        ['dragleave', 'drop'].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault();
                dropZone.classList.remove('border-green-500', 'bg-green-50');
            });
        });

        dropZone.addEventListener('drop', e => {
            if (!e.dataTransfer || !e.dataTransfer.files.length) return;
            input.files = e.dataTransfer.files;
            window.previewProductImage(input);
        });
/* ---------- Live price / stock maths ---------- */
    const price      = document.getElementById('price');
    const stock      = document.getElementById('stock');
    const invValue   = document.getElementById('inventoryValue');
    const stockHint  = document.getElementById('stockHint');
    const nameInput  = document.getElementById('name');
    const catInput   = document.getElementById('category');
    const prevName   = document.getElementById('previewName');
    const prevPrice  = document.getElementById('previewPrice');
    const prevStock  = document.getElementById('previewStock');
    const prevCat    = document.getElementById('previewCategory');

    function fmt(n) {
        return 'KES ' + Number(n || 0).toLocaleString('en-KE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function refreshNumbers() {
        const p = parseFloat(price && price.value) || 0;
        const s = parseInt(stock && stock.value, 10) || 0;

        if (invValue) invValue.textContent = fmt(p * s);

        if (stockHint) {
            stockHint.textContent = s === 0
                ? 'Out of stock — customers cannot buy this.'
                : (s < 10 ? 'Low stock — this will raise a low-stock alert.' : '');
        }

        if (prevName)  prevName.textContent  = (nameInput && nameInput.value) || 'Untitled product';
        if (prevPrice) prevPrice.textContent = fmt(p);
        if (prevStock) prevStock.textContent = s > 0 ? s + ' in stock' : 'Out of stock';

        if (prevCat && catInput && catInput.value) {
            prevCat.textContent = catInput.value.charAt(0).toUpperCase() + catInput.value.slice(1);
        }
    }

    [price, stock, nameInput, catInput].forEach(el => {
        if (el) el.addEventListener('input', refreshNumbers);
    });
    refreshNumbers();

    /* ---------- Description counter ---------- */
    const desc      = document.getElementById('description');
    const descCount = document.getElementById('descCount');

    function refreshCount() {
        if (desc && descCount) descCount.textContent = desc.value.length;
    }

    if (desc) {
        desc.addEventListener('input', refreshCount);
        refreshCount();
    }

    /* ---------- Active badge in header ---------- */
    const isActive    = document.getElementById('is_active');
    const headerBadge = document.getElementById('headerStatusBadge');

    if (isActive && headerBadge) {
        isActive.addEventListener('change', () => {
            headerBadge.textContent = isActive.checked ? 'Active' : 'Inactive';
            headerBadge.classList.toggle('bg-lime-300', isActive.checked);
            headerBadge.classList.toggle('text-green-900', isActive.checked);
            headerBadge.classList.toggle('bg-white/20', ! isActive.checked);
            headerBadge.classList.toggle('text-white', ! isActive.checked);
        });
    }

    /* ---------- Pre-submit file check ---------- */
    const MAX_BYTES = 5 * 1024 * 1024; // must match the server's max:5120 (KB)
    const ALLOWED  = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (form && input) {
        form.addEventListener('submit', e => {
            const file = input.files && input.files[0];

            if (!file) return; // nothing chosen - saved photo is kept

            if (file.size > MAX_BYTES) {
                e.preventDefault();
                alert('That image is ' + humanSize(file.size) + ', which is over the 5 MB limit. Please choose a smaller file.');
                return;
            }

            // HEIC/AVIF etc. are rejected by the server's mimes rule - fail fast
            // with a clear message rather than bouncing off a validation error.
            if (file.type && ALLOWED.indexOf(file.type) === -1) {
                e.preventDefault();
                alert('That file type (' + file.type + ') is not supported. Please upload a JPEG, PNG, GIF or WEBP image.');
            }
        });
    }

    /* ---------- Unsaved changes guard ---------- */
    const form       = document.getElementById('productForm');
    const notice     = document.getElementById('unsavedNotice');
    const savedState = document.getElementById('savedState');

    if (form) {
        let dirty = false;

        form.addEventListener('input', () => {
            dirty = true;
            if (notice) {
                notice.classList.remove('hidden');
                notice.classList.add('flex');
            }
            if (savedState) savedState.classList.add('hidden');
        });

        form.addEventListener('submit', () => { dirty = false; });

        // Guard against accidental navigation losing edits.
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('click', e => {
                if (!dirty) return;
                if (!confirm('You have unsaved changes. Leave without saving?')) {
                    e.preventDefault();
                }
            });
        });

        // Browser-level back/forward/close protection.
        window.addEventListener('beforeunload', e => {
            if (!dirty) return;
            e.preventDefault();
            e.returnValue = '';
        });
    }
});
</script>
@endpush
    }