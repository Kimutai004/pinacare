@extends('storefront.layouts.app')
@section('title', 'Sustainable Baby Care')

@section('content')
{{-- ===== HERO ===== --}}
<section class="relative bg-gradient-to-b from-green-50 to-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div class="text-center md:text-left">
                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full mb-4">🌱 New & Eco-Friendly</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-green-800 leading-tight">
                    Where <span class="text-green-500">Sustainability</span><br>Meets Baby Care
                </h1>
                <p class="mt-4 text-lg text-gray-600 leading-relaxed max-w-lg">
                    100% biodegradable diapers and wipes — gentle on your baby's skin and kind to our planet. Join the circular economy revolution.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row items-center gap-4 justify-center md:justify-start">
                    <a href="{{ route('store.shop') }}" class="px-8 py-3.5 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow-lg text-lg flex items-center gap-2">
                        Shop Now
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('store.impact') }}" class="px-6 py-3.5 border-2 border-green-600 text-green-700 font-bold rounded-full hover:bg-green-50 transition flex items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                        Our Impact
                    </a>
                </div>
            </div>
            <div class="relative flex justify-center">
                <div class="w-72 h-72 md:w-96 md:h-96 rounded-full bg-green-100 flex items-center justify-center float shadow-inner">
                    <span class="text-8xl md:text-9xl">🍃</span>
                </div>
                <div class="absolute -bottom-4 -left-4 bg-white rounded-xl shadow-lg p-3 flex items-center gap-2">
                    <span class="text-2xl">🌱</span>
                    <div><p class="text-xs font-bold text-green-700">100% Biodegradable</p><p class="text-[10px] text-gray-500">BPA-Free Materials</p></div>
                </div>
                <div class="absolute -top-4 -right-4 bg-white rounded-xl shadow-lg p-3 flex items-center gap-2">
                    <span class="text-2xl">👶</span>
                    <div><p class="text-xs font-bold text-blue-600">Baby-Safe</p><p class="text-[10px] text-gray-500">Hypoallergenic</p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-green-300 to-transparent"></div>
</section>

{{-- ===== QUICK HIGHLIGHTS ===== --}}
<section class="py-12 bg-white">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="text-center p-6 rounded-2xl bg-green-50 border border-green-100">
            <span class="text-4xl">🌱</span>
            <h3 class="text-lg font-bold text-green-800 mt-3">100% Biodegradable</h3>
            <p class="text-sm text-gray-600 mt-2">Made from plant-based materials that decompose naturally.</p>
        </div>
        <div class="text-center p-6 rounded-2xl bg-blue-50 border border-blue-100">
            <span class="text-4xl">👶</span>
            <h3 class="text-lg font-bold text-blue-800 mt-3">Gentle on Baby Skin</h3>
            <p class="text-sm text-gray-600 mt-2">Hypoallergenic, dermatologist-tested for sensitive skin.</p>
        </div>
        <div class="text-center p-6 rounded-2xl bg-amber-50 border border-amber-100">
            <span class="text-4xl">♻️</span>
            <h3 class="text-lg font-bold text-amber-800 mt-3">Circular Economy</h3>
            <p class="text-sm text-gray-600 mt-2">Every purchase supports a closed-loop, zero-waste system.</p>
        </div>
    </div>
</section>

{{-- ===== FEATURED PRODUCTS ===== --}}
<section class="py-16 bg-green-50/50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-green-800">Our Premium Collection</h2>
            <p class="text-gray-600 mt-2">Carefully crafted for your little one and our planet.</p>
        </div>
        @if($featuredProducts->count())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($featuredProducts as $product)
            <a href="{{ route('store.product', $product) }}" class="group bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
                <div class="aspect-square bg-green-50 flex items-center justify-center p-6 group-hover:bg-green-100 transition-colors">
                    <span class="text-6xl">{{ $product->category === 'diaper' ? '🩲' : ($product->category === 'wipe' ? '🧻' : '📦') }}</span>
                </div>
                <div class="p-4">
                    <span class="text-xs font-semibold text-green-600 uppercase">{{ $product->category }}</span>
                    <h3 class="font-bold text-gray-800 mt-1">{{ $product->name }}</h3>
                    @if($product->size)<span class="text-xs text-gray-500">Size {{ $product->size }}</span>@endif
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-lg font-extrabold text-green-700">KES {{ number_format($product->price) }}</span>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('store.shop') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow">View All Products <span class="ml-2">→</span></a>
        </div>
        @endif
    </div>
</section>

{{-- ===== IMPACT COUNTER ===== --}}
@if($impact)
<section class="py-16 bg-green-700 text-white">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Together, We're Making a Difference</h2>
        <p class="text-green-100 text-lg mb-8">Every purchase contributes to a healthier planet.</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-green-600/50 rounded-2xl p-8 backdrop-blur">
                <span class="text-5xl">🩲</span>
                <p class="text-4xl font-extrabold mt-3">{{ number_format($impact->diapers_saved) }}+</p>
                <p class="text-green-200 text-sm mt-1">Diapers Saved from Landfills</p>
            </div>
            <div class="bg-green-600/50 rounded-2xl p-8 backdrop-blur">
                <span class="text-5xl">🌍</span>
                <p class="text-4xl font-extrabold mt-3">{{ number_format($impact->co2_reduced, 1) }} kg</p>
                <p class="text-green-200 text-sm mt-1">CO₂ Emissions Reduced</p>
            </div>
            <div class="bg-green-600/50 rounded-2xl p-8 backdrop-blur">
                <span class="text-5xl">👨‍🌾</span>
                <p class="text-4xl font-extrabold mt-3">{{ number_format($impact->farmers_supported) }}+</p>
                <p class="text-green-200 text-sm mt-1">Farmers Supported</p>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== TESTIMONIALS ===== --}}
@if($testimonials->count())
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-green-800 mb-10">What Parents Say</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
            <div class="bg-green-50 rounded-2xl p-6 border border-green-100">
                <div class="flex text-yellow-400 mb-3">@for($i=0;$i<5;$i++)<svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 {{ $i < $t->rating ? '' : 'text-gray-300' }}"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor</div>
                <p class="text-sm text-gray-600 italic">"{{ $t->content }}"</p>
                <p class="text-sm font-bold text-green-700 mt-3">— {{ $t->customer?->name ?? 'Verified Parent' }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-6">
            <a href="{{ route('store.community') }}" class="text-green-700 font-bold hover:underline">Read more reviews →</a>
        </div>
    </div>
</section>
@endif

{{-- ===== BLOG PREVIEW ===== --}}
@if($posts->count())
<section class="py-16 bg-green-50/50">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-green-800 mb-10">From Our Blog</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <a href="{{ route('store.blog', $post->slug) }}" class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition border border-green-100">
                <span class="text-xs text-green-600 font-bold uppercase">{{ $post->created_at->format('M d, Y') }}</span>
                <h3 class="font-bold text-gray-800 mt-1 text-lg">{{ $post->title }}</h3>
                <p class="text-sm text-gray-600 mt-2">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                <span class="text-green-700 text-sm font-bold mt-3 inline-block hover:underline">Read More →</span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== CTA NEWSLETTER ===== --}}
<section class="py-16 bg-green-800 text-white">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <span class="text-5xl">🌱</span>
        <h2 class="text-3xl font-extrabold mt-4">Join the PINACARE Family</h2>
        <p class="text-green-200 mt-2">Get tips on eco-parenting, exclusive offers, and impact updates.</p>
        <form method="POST" action="{{ route('store.newsletter') }}" class="mt-6 flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            @csrf
            <input type="email" name="email" placeholder="Your email address" required class="flex-1 px-4 py-3 rounded-full text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            <button type="submit" class="px-6 py-3 bg-green-500 text-white font-bold rounded-full hover:bg-green-400 transition text-sm">Subscribe</button>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Mobile menu toggle
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        const menu = document.getElementById('mobileMenu');
        if(menu) menu.classList.toggle('hidden');
    });
</script>
@endpush
