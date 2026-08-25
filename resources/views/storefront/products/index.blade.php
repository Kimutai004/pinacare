@extends('storefront.layouts.app')
@section('title', 'Shop All Products')

@section('content')
{{-- ===== 1. HERO BANNER ===== --}}
<section class="relative overflow-hidden bg-gradient-to-r from-green-800 via-green-700 to-emerald-800 text-white">
    <div class="absolute -top-16 -right-16 w-72 h-72 rounded-full bg-green-400/15 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-16 w-72 h-72 rounded-full bg-emerald-300/15 blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-16 md:py-20 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-green-200 text-xs font-bold tracking-widest uppercase rounded-full mb-6">
            <span class="text-green-300">@include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-4 h-4'])</span>
            The Collection
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">{{ request('category') ? ucfirst(request('category')).'s' : 'Shop Our Products' }}</h1>
        <p class="text-green-100 mt-4 text-lg max-w-2xl mx-auto">Eco-friendly diapers, wipes & bundles crafted with love for your little one and the planet.</p>
    </div>
</section>

{{-- ===== 2. CATEGORY FILTER TABS ===== --}}
<section class="py-10 bg-[#faf8f3]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 bg-white rounded-full p-2 border border-green-100 shadow-sm max-w-max mx-auto">
            <a href="{{ route('store.shop') }}" class="px-5 py-2.5 rounded-full text-sm font-bold transition {{ !request('category') ? 'bg-green-700 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                <span class="inline-flex items-center gap-1.5">
                    @include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-4 h-4'])
                    All
                </span>
            </a>
            @foreach(['diaper','wipe','bundle'] as $cat)
                <a href="{{ route('store.shop', ['category' => $cat]) }}"
                   class="px-5 py-2.5 rounded-full text-sm font-bold transition {{ request('category') === $cat ? 'bg-green-700 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                    <span class="inline-flex items-center gap-1.5">
                        @include('storefront.partials.icons', ['icon' => $cat === 'diaper' ? 'diaper' : ($cat === 'wipe' ? 'wipe' : 'bundle'), 'class' => 'w-4 h-4'])
                        {{ ucfirst($cat) }}s
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 3. PRODUCT GRID ===== --}}
<section class="py-10 pb-16 bg-[#faf8f3]">
    <div class="max-w-7xl mx-auto px-4">
        @if($products->count())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $product)
            <a href="{{ route('store.product', $product) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition overflow-hidden border border-gray-100 hover:border-green-200 hover:-translate-y-1 duration-300">
                <div class="relative aspect-square {{ $product->category === 'diaper' ? 'bg-gradient-to-br from-green-50 to-white' : ($product->category === 'wipe' ? 'bg-gradient-to-br from-blue-50 to-white' : 'bg-gradient-to-br from-amber-50 to-white') }} flex items-center justify-center p-6 group-hover:bg-green-100 transition-colors">
                    @if(true)
                        <img src="{{ asset('Medium (Front view).png') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                    @else
                    <span class="w-24 h-24 {{ $product->category === 'diaper' ? 'text-green-600' : ($product->category === 'wipe' ? 'text-blue-600' : 'text-amber-600') }} group-hover:scale-110 transition-transform">
                        @include('storefront.partials.icons', ['icon' => $product->category === 'diaper' ? 'diaper' : ($product->category === 'wipe' ? 'wipe' : 'bundle'), 'class' => 'w-full h-full'])
                    </span>
                    @endif
                    @if($product->stock <= 0)
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-red-500 text-white text-[10px] font-extrabold rounded-full shadow">Out of Stock</span>
                    @elseif($product->stock <= 10)
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-amber-400 text-white text-[10px] font-extrabold rounded-full shadow">Low Stock</span>
                    @endif
                    <span class="absolute top-3 left-3 px-2.5 py-1 bg-white/90 backdrop-blur text-{{ $product->category === 'diaper' ? 'green' : ($product->category === 'wipe' ? 'blue' : 'amber') }}-600 text-[10px] font-extrabold uppercase tracking-wider rounded-full shadow">{{ $product->category }}</span>
                </div>
                <div class="p-4">
                    @if($product->size)<span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Size {{ $product->size }}</span>@endif
                    <h3 class="font-bold text-gray-800 mt-1 text-sm md:text-base leading-tight">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-lg font-extrabold text-gray-900">KES {{ number_format($product->price) }}</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-10">{{ $products->links() }}</div>
        @else
        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-green-50">
            <div class="w-20 h-20 rounded-full bg-green-50 text-green-600 flex items-center justify-center mx-auto">
                @include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-10 h-10'])
            </div>
            <h3 class="text-xl font-bold text-gray-600 mt-4">No products found</h3>
            <p class="text-gray-500 mt-1">Try a different category or check back soon.</p>
            <a href="{{ route('store.shop') }}" class="inline-block mt-6 px-6 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition">View All</a>
        </div>
        @endif
    </div>
</section>

{{-- ===== 4. SUBSCRIPTION CTA — Split card ===== --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4">
        <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-green-700 to-emerald-900 text-white shadow-2xl">
            <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-green-400/20 blur-3xl"></div>
            <div class="grid md:grid-cols-2 gap-8 items-center p-10 md:p-14">
                <div class="relative">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur border border-white/20 text-green-200 flex items-center justify-center mb-5">
                        <span class="w-8 h-8">@include('storefront.partials.icons', ['icon' => 'box', 'class' => 'w-full h-full'])</span>
                    </div>
                    <h2 class="text-3xl font-extrabold leading-tight">Never Run Out of Diapers!</h2>
                    <p class="text-green-100 mt-3">Subscribe & Save — get monthly deliveries at discounted prices. Pause or cancel anytime.</p>
                </div>
                <div class="relative text-center md:text-right">
                    <p class="text-5xl font-extrabold text-green-300">15%<span class="text-2xl"> off</span></p>
                    <p class="text-green-100 text-sm mt-1">on every subscription order</p>
                    <a href="{{ route('store.shop') }}" class="inline-block mt-6 px-8 py-3.5 bg-white text-green-700 font-extrabold rounded-full hover:bg-green-50 transition shadow-lg">Start Subscription</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>
@endpush
