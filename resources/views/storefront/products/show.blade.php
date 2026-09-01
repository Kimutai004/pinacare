@extends('storefront.layouts.app')
@section('title', $product->name)

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Breadcrumbs --}}
    <nav class="text-sm mb-8 flex items-center gap-2 text-gray-500">
        <a href="{{ route('store.home') }}" class="hover:text-green-700 inline-flex items-center gap-1">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            Home
        </a>
        <span>/</span>
        <a href="{{ route('store.shop') }}" class="hover:text-green-700">Shop</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold">{{ $product->name }}</span>
    </nav>

    <div class="grid md:grid-cols-2 gap-10 lg:gap-14">
        {{-- Image panel --}}
        <div class="relative">
<div class="aspect-square {{ $product->category === 'diaper' ? 'bg-gradient-to-br from-green-50 to-emerald-50' : ($product->category === 'wipe' ? 'bg-gradient-to-br from-blue-50 to-cyan-50' : 'bg-gradient-to-br from-amber-50 to-yellow-50') }} rounded-[2rem] flex items-center justify-center border border-{{ $product->category === 'diaper' ? 'green' : ($product->category === 'wipe' ? 'blue' : 'amber') }}-100 shadow-inner relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/40 blur-sm"></div>
                @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                <span class="w-56 h-56 {{ $product->category === 'diaper' ? 'text-green-600' : ($product->category === 'wipe' ? 'text-blue-600' : 'text-amber-600') }} float">
                    @include('storefront.partials.icons', ['icon' => $product->category === 'diaper' ? 'diaper' : ($product->category === 'wipe' ? 'wipe' : 'bundle'), 'class' => 'w-full h-full'])
                </span>
                @endif
                @if($product->stock <= 0)
                <span class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-xs font-extrabold rounded-full shadow">Out of Stock</span>
                @elseif($product->stock <= 10)
                <span class="absolute top-4 left-4 px-3 py-1 bg-amber-400 text-white text-xs font-extrabold rounded-full shadow">Only {{ $product->stock }} left</span>
                @endif
            </div>
            {{-- Trust badges --}}
            <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="flex flex-col items-center p-5 rounded-2xl bg-gradient-to-br from-green-50 to-green-100/60 border border-green-200 hover:shadow-lg hover:border-green-300 hover:scale-105 transition-all duration-300 cursor-pointer">
                    <span class="w-10 h-10 text-green-600 mb-2">@include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-full h-full'])</span>
                    <p class="text-xs font-bold text-green-700">Biodegradable</p>
                    <p class="text-[10px] text-green-600 mt-0.5">100% Natural</p>
                </div>
                <div class="flex flex-col items-center p-5 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100/60 border border-blue-200 hover:shadow-lg hover:border-blue-300 hover:scale-105 transition-all duration-300 cursor-pointer">
                    <span class="w-10 h-10 text-blue-600 mb-2">@include('storefront.partials.icons', ['icon' => 'baby', 'class' => 'w-full h-full'])</span>
                    <p class="text-xs font-bold text-blue-700">Baby-Safe</p>
                    <p class="text-[10px] text-blue-600 mt-0.5">Hypoallergenic</p>
                </div>
                <div class="flex flex-col items-center p-5 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100/60 border border-amber-200 hover:shadow-lg hover:border-amber-300 hover:scale-105 transition-all duration-300 cursor-pointer">
                    <span class="w-10 h-10 text-amber-600 mb-2">@include('storefront.partials.icons', ['icon' => 'recycle', 'class' => 'w-full h-full'])</span>
                    <p class="text-xs font-bold text-amber-700">Eco-Circular</p>
                    <p class="text-[10px] text-amber-600 mt-0.5">Sustainable</p>
                </div>
            </div>
        </div>

        {{-- Details --}}
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">{{ ucfirst($product->category) }}</span>
                @if($product->size)<span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">
                    @include('storefront.partials.icons', ['icon' => 'box', 'class' => 'w-3.5 h-3.5']) Size {{ $product->size }}
                </span>@endif
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-3">{{ $product->name }}</h1>

            <div class="mt-4 flex items-center gap-3">
                <span class="text-3xl md:text-4xl font-extrabold text-green-700">KES {{ number_format($product->price) }}</span>
                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>

            <p class="mt-5 text-gray-600 leading-relaxed text-lg">{{ $product->description ?? 'Eco-friendly, baby-safe, and biodegradable — crafted with love for your little one and the planet.' }}</p>

            {{-- Key Features --}}
            <div class="mt-7 bg-green-50 rounded-2xl p-5 border border-green-100 space-y-2.5">
                <div class="flex items-center gap-2 text-sm text-gray-700"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'check', 'class' => 'w-4 h-4'])</span> 100% Biodegradable</div>
                <div class="flex items-center gap-2 text-sm text-gray-700"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'check', 'class' => 'w-4 h-4'])</span> Hypoallergenic · Dermatologist Tested</div>
                <div class="flex items-center gap-2 text-sm text-gray-700"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'check', 'class' => 'w-4 h-4'])</span> Chemical-Free · BPA-Free</div>
                @if($product->category === 'diaper')
                <div class="flex items-center gap-2 text-sm text-gray-700"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'check', 'class' => 'w-4 h-4'])</span> Super Absorbent · Leak-Proof</div>
                @endif
            </div>

            {{-- Actions --}}
            @if($product->stock > 0)
            <div class="mt-8 space-y-4">
                <form method="POST" action="{{ route('store.cart.add') }}" class="flex items-center gap-4" id="addToCartForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center border border-gray-300 rounded-full bg-white">
                        <button type="button" onclick="decreaseQty()" class="px-3 py-2 text-gray-600 hover:text-green-700">−</button>
                        <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center text-sm font-bold border-0 focus:outline-none" readonly id="qtyInput">
                        <button type="button" onclick="increaseQty()" class="px-3 py-2 text-gray-600 hover:text-green-700">+</button>
                    </div>
                    <button type="submit" class="flex-1 px-6 py-3.5 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow flex items-center justify-center gap-2" id="addToCartBtn">
                        @include('storefront.partials.icons', ['icon' => 'cart', 'class' => 'w-4 h-4'])
                        Add to Cart — KES {{ number_format($product->price) }}
                    </button>
                </form>
                <a href="{{ route('store.checkout') }}" class="w-full text-center px-6 py-3.5 border-2 border-green-600 text-green-700 font-bold rounded-full hover:bg-green-50 transition flex items-center justify-center gap-2">
                    @include('storefront.partials.icons', ['icon' => 'recycle', 'class' => 'w-4 h-4'])
                    Subscribe & Save 15%
                </a>
            </div>
            @else
            <div class="mt-8 px-6 py-5 bg-red-50 border border-red-200 rounded-2xl text-red-700 font-bold text-center flex items-center justify-center gap-2">
                @include('storefront.partials.icons', ['icon' => 'box', 'class' => 'w-5 h-5'])
                Out of Stock — Check back soon!
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ===== Related Products ===== --}}
@if($related->count())
<section class="bg-gradient-to-b from-green-50/80 to-green-100/40 py-16 mt-12 border-t border-green-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-green-900">You May Also Like</h2>
                <p class="text-green-700 mt-2 text-sm">Complete your sustainable baby care collection</p>
            </div>
            <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-green-600 text-green-700 font-bold rounded-full hover:bg-green-50 transition-all duration-300 shadow-sm">
                View All Products
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($related as $r)
            <a href="{{ route('store.product', $r) }}" class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 hover:border-green-400 hover:-translate-y-3">
                <!-- Product Image Area -->
                <div class="relative w-full aspect-square {{ $r->category === 'diaper' ? 'bg-gradient-to-br from-green-50 to-emerald-50' : ($r->category === 'wipe' ? 'bg-gradient-to-br from-blue-50 to-cyan-50' : 'bg-gradient-to-br from-amber-50 to-yellow-50') }} flex items-center justify-center overflow-hidden">
                    @if($r->image_url)
                        <img src="{{ asset($r->image_url) }}" alt="{{ $r->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <span class="w-32 h-32 {{ $r->category === 'diaper' ? 'text-green-600' : ($r->category === 'wipe' ? 'text-blue-600' : 'text-amber-600') }} group-hover:scale-130 group-hover:rotate-6 transition-transform duration-300">
                            @include('storefront.partials.icons', ['icon' => $r->category === 'diaper' ? 'diaper' : ($r->category === 'wipe' ? 'wipe' : 'bundle'), 'class' => 'w-full h-full'])
                        </span>
                    @endif
                    @if($r->stock <= 0)
                    <span class="absolute top-4 right-4 px-3 py-1.5 bg-red-500 text-white text-xs font-extrabold rounded-full shadow-lg">Out of Stock</span>
                    @elseif($r->stock <= 5)
                    <span class="absolute top-4 right-4 px-3 py-1.5 bg-amber-500 text-white text-xs font-extrabold rounded-full shadow-lg">Only {{ $r->stock }} left</span>
                    @endif
                    <!-- Category Badge -->
                    <span class="absolute bottom-4 left-4 px-3 py-1.5 bg-white/95 backdrop-blur text-gray-800 text-xs font-bold rounded-full shadow-md">{{ ucfirst($r->category) }}</span>
                </div>
                
                <!-- Product Info -->
                <div class="p-5 flex flex-col gap-3">
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 leading-tight">{{ $r->name }}</h3>
                    
                    <!-- Price Section - Prominent -->
                    <div class="py-2 border-y border-gray-200">
                        <div class="flex items-baseline justify-between gap-2">
                            <span class="text-xl font-bold text-green-700">KES {{ number_format($r->price) }}</span>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest {{ $r->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $r->stock > 0 ? 'In Stock' : 'Out' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Quick Action Button -->
                    <button type="button" class="w-full py-2 px-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold text-xs rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 group-hover:scale-105 transform shadow-md hover:shadow-lg">
                        View Product →
                    </button>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
    const productPrice = {{ $product->price }};
    
    function updateCartButtonAmount() {
        const qty = parseInt(document.getElementById('qtyInput').value) || 1;
        const total = productPrice * qty;
        const formattedTotal = total.toLocaleString('en-US');
        document.getElementById('addToCartBtn').innerHTML = `
            @include('storefront.partials.icons', ['icon' => 'cart', 'class' => 'w-4 h-4'])
            Add to Cart — KES ${formattedTotal}
        `;
    }
    
    function increaseQty() {
        const input = document.getElementById('qtyInput');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
            updateCartButtonAmount();
        }
    }
    
    function decreaseQty() {
        const input = document.getElementById('qtyInput');
        const min = parseInt(input.min);
        if (parseInt(input.value) > min) {
            input.value = parseInt(input.value) - 1;
            updateCartButtonAmount();
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartButtonAmount();
    });
    
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>
@endpush
