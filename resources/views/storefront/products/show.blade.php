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
            <div class="mt-4 grid grid-cols-3 gap-3">
                <div class="text-center p-3 rounded-xl bg-white border border-green-100">
                    <span class="w-6 h-6 text-green-600 mx-auto">@include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-full h-full'])</span>
                    <p class="text-[10px] font-bold text-gray-600 mt-1">Biodegradable</p>
                </div>
                <div class="text-center p-3 rounded-xl bg-white border border-green-100">
                    <span class="w-6 h-6 text-blue-600 mx-auto">@include('storefront.partials.icons', ['icon' => 'baby', 'class' => 'w-full h-full'])</span>
                    <p class="text-[10px] font-bold text-gray-600 mt-1">Baby-Safe</p>
                </div>
                <div class="text-center p-3 rounded-xl bg-white border border-green-100">
                    <span class="w-6 h-6 text-amber-600 mx-auto">@include('storefront.partials.icons', ['icon' => 'recycle', 'class' => 'w-full h-full'])</span>
                    <p class="text-[10px] font-bold text-gray-600 mt-1">Eco-Circular</p>
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
                <form method="POST" action="{{ route('store.cart.add') }}" class="flex items-center gap-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center border border-gray-300 rounded-full bg-white">
                        <button type="button" onclick="this.parentNode.querySelector('input').stepDown();this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-3 py-2 text-gray-600 hover:text-green-700">−</button>
                        <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center text-sm font-bold border-0 focus:outline-none" readonly>
                        <button type="button" onclick="this.parentNode.querySelector('input').stepUp();this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-3 py-2 text-gray-600 hover:text-green-700">+</button>
                    </div>
                    <button type="submit" class="flex-1 px-6 py-3.5 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow flex items-center justify-center gap-2">
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
<section class="bg-green-50/50 py-14 mt-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-extrabold text-green-800">You May Also Like</h2>
            <a href="{{ route('store.shop') }}" class="text-sm text-green-700 font-bold hover:underline inline-flex items-center gap-1">View All
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($related as $r)
            <a href="{{ route('store.product', $r) }}" class="group bg-white rounded-2xl p-5 shadow-sm hover:shadow-xl transition text-center border border-gray-100 hover:border-green-200 hover:-translate-y-1 duration-300">
                <span class="w-16 h-16 {{ $r->category === 'diaper' ? 'text-green-600' : ($r->category === 'wipe' ? 'text-blue-600' : 'text-amber-600') }} mx-auto group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => $r->category === 'diaper' ? 'diaper' : ($r->category === 'wipe' ? 'wipe' : 'bundle'), 'class' => 'w-full h-full'])
                </span>
                <h3 class="font-bold text-sm text-gray-800 mt-2">{{ $r->name }}</h3>
                <span class="text-green-700 font-extrabold">KES {{ number_format($r->price) }}</span>
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
