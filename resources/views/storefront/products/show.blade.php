@extends('storefront.layouts.app')
@section('title', $product->name)

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="text-sm breadcrumbs mb-6 text-gray-500">
        <a href="{{ route('store.home') }}" class="hover:text-green-700">Home</a> /
        <a href="{{ route('store.shop') }}" class="hover:text-green-700">Shop</a> /
        <span class="text-gray-800 font-semibold">{{ $product->name }}</span>
    </nav>

    <div class="grid md:grid-cols-2 gap-10">
        <!-- Image -->
        <div class="aspect-square bg-gradient-to-br from-green-50 to-white rounded-3xl flex items-center justify-center shadow-inner border border-green-100">
            <span class="text-9xl">{{ $product->category === 'diaper' ? '🩲' : ($product->category === 'wipe' ? '🧻' : '📦') }}</span>
        </div>

        <!-- Details -->
        <div>
            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full mb-3">{{ ucfirst($product->category) }}</span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800">{{ $product->name }}</h1>
            @if($product->size)<p class="text-gray-500 mt-1">Size: <span class="font-bold text-gray-700">{{ $product->size }}</span></p>@endif

            <div class="mt-4 flex items-center space-x-2">
                <span class="text-3xl font-extrabold text-green-700">KES {{ number_format($product->price) }}</span>
                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>

            <p class="mt-4 text-gray-600 leading-relaxed">{{ $product->description ?? 'Eco-friendly, baby-safe, and biodegradable — crafted with love for your little one and the planet.' }}</p>

            <!-- Key Features -->
            <div class="mt-6 space-y-2">
                <div class="flex items-center gap-2 text-sm"><span class="text-green-600">✅</span> 100% Biodegradable</div>
                <div class="flex items-center gap-2 text-sm"><span class="text-green-600">✅</span> Hypoallergenic · Dermatologist Tested</div>
                <div class="flex items-center gap-2 text-sm"><span class="text-green-600">✅</span> Chemical-Free · BPA-Free</div>
                @if($product->category === 'diaper')
                <div class="flex items-center gap-2 text-sm"><span class="text-green-600">✅</span> Super Absorbent · Leak-Proof</div>
                @endif
            </div>

            <!-- Actions -->
            @if($product->stock > 0)
            <div class="mt-8 space-y-4">
                <form method="POST" action="{{ route('store.cart.add') }}" class="flex items-center gap-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center border border-gray-300 rounded-full">
                        <button type="button" onclick="this.parentNode.querySelector('input').stepDown();this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-3 py-2 text-gray-600 hover:text-green-700">−</button>
                        <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center text-sm font-bold border-0 focus:outline-none" readonly>
                        <button type="button" onclick="this.parentNode.querySelector('input').stepUp();this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-3 py-2 text-gray-600 hover:text-green-700">+</button>
                    </div>
                    <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow">
                        Add to Cart — KES {{ number_format($product->price) }}
                    </button>
                </form>
                <form method="POST" action="{{ route('store.checkout') }}" class="flex items-center gap-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="1">
                    <a href="{{ route('store.checkout') }}" class="w-full text-center px-6 py-3 border-2 border-green-600 text-green-700 font-bold rounded-full hover:bg-green-50 transition">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 inline mr-1"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2L15 20"/></svg>
                        Subscribe & Save
                    </a>
                </form>
            </div>
            @else
            <div class="mt-8 px-6 py-4 bg-red-50 border border-red-200 rounded-xl text-red-700 font-bold text-center">Out of Stock — Check back soon!</div>
            @endif
        </div>
    </div>
</section>

{{-- ===== Related Products ===== --}}
@if($related->count())
<section class="bg-green-50/50 py-12 mt-6">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-green-800 mb-6">You May Also Like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($related as $r)
            <a href="{{ route('store.product', $r) }}" class="bg-white rounded-2xl p-4 shadow hover:shadow-lg transition text-center border border-green-50">
                <span class="text-5xl">{{ $r->category === 'diaper' ? '🩲' : ($r->category === 'wipe' ? '🧻' : '📦') }}</span>
                <h3 class="font-bold text-sm text-gray-800 mt-2">{{ $r->name }}</h3>
                <span class="text-green-700 font-bold">KES {{ number_format($r->price) }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>
@endpush
