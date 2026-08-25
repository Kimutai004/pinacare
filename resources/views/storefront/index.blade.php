@extends('storefront.layouts.app')
@section('title', 'Sustainable Baby Care')

@section('content')
{{-- ============================================================
     1. HERO SECTION — Full-bleed split layout with wave divider
============================================================= --}}
<section class="relative min-h-screen flex items-center overflow-hidden bg-[#0b3d2e]">
    {{-- Layered background --}}
<div class="absolute inset-0">
    <img src="{{ asset('Single flat view.png') }}"
         alt="Eco baby care"
         class="w-full h-full object-cover opacity-30">

    {{-- Dark Forest Green Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#062e12] via-[#0b4a1b] to-[#145a20]"></div>

    {{-- Decorative blobs --}}
    <div class="absolute -top-32 -right-32 w-[480px] h-[480px] rounded-full bg-[#1f7a2e]/20 blur-3xl"></div>
    <div class="absolute bottom-0 -left-24 w-[360px] h-[360px] rounded-full bg-[#3f9142]/10 blur-3xl"></div>
</div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-24 w-full">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            {{-- Left: copy --}}
            <div class="text-center lg:text-left">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-green-200 text-xs font-bold tracking-widest uppercase rounded-full mb-7">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    100% Biodegradable · Eco-Friendly
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-white leading-[1.05]">
                    Gentle on Baby.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 via-emerald-200 to-green-300">Kind to the Earth.</span>
                </h1>
                <p class="mt-6 text-lg md:text-xl text-green-50/90 leading-relaxed max-w-xl mx-auto lg:mx-0">
                    PINACARE crafts 100% biodegradable diapers &amp; wipes from pineapple leaf fibres — protecting your little one's skin and our planet, one nappy at a time.
                </p>
                <div class="mt-9 flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                    <a href="{{ route('store.shop') }}" class="group inline-flex items-center justify-center px-8 py-4 bg-green-400 text-[#0b3d2e] font-extrabold rounded-full hover:bg-green-300 transition shadow-2xl shadow-green-500/30 text-lg">
                        Shop Now
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('store.about') }}" class="inline-flex items-center justify-center px-7 py-4 border-2 border-white/40 text-white font-bold rounded-full hover:bg-white hover:text-[#0b3d2e] transition text-lg">
                        Who We Are
                    </a>
                </div>

                {{-- Trust indicators --}}
                <div class="mt-12 grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0">
                    <div class="border-l-2 border-green-400 pl-3 text-left">
                        <p class="text-2xl font-extrabold text-white">100%</p>
                        <p class="text-xs text-green-100/80 mt-1">Biodegradable</p>
                    </div>
                    <div class="border-l-2 border-green-400 pl-3 text-left">
                        <p class="text-2xl font-extrabold text-white">BPA-Free</p>
                        <p class="text-xs text-green-100/80 mt-1">Safe Materials</p>
                    </div>
                    <div class="border-l-2 border-green-400 pl-3 text-left">
                        <p class="text-2xl font-extrabold text-white">Child-Safe</p>
                        <p class="text-xs text-green-100/80 mt-1">Hypoallergenic</p>
                    </div>
                </div>
            </div>

            {{-- Right: floating product visual --}}
            <div class="relative hidden lg:block">
                <div class="relative mx-auto w-[420px] h-[420px] md:w-[520px] md:h-[520px]">

    {{-- Glow behind the circle --}}
    <div class="absolute inset-0 rounded-full bg-green-400/30 blur-3xl"></div>

    {{-- Full circular dashed path --}}
    <div class="absolute inset-0 rounded-full border-2 border-dashed border-green-300/60 animate-spin-slow"></div>

    {{-- Product image - fills the entire circle --}}
    <div class="absolute inset-2 rounded-full overflow-hidden border-4 border-white/20 shadow-2xl">
        <img src="{{ asset('Medium (Front View).png') }}" alt="PINACARE Eco Baby Care" class="w-full h-full object-cover">

    </div>

    {{-- Subtle glass overlay --}}
    <div class="absolute inset-2 rounded-full bg-gradient-to-t from-green-950/20 via-transparent to-white/10 pointer-events-none"></div>

</div>

                {{-- Floating badges --}}
                <div class="absolute top-8 -left-2 bg-white/95 backdrop-blur rounded-2xl px-4 py-3 shadow-xl flex items-center gap-3 float">
                    <div class="w-10 h-10 rounded-full bg-green-700 text-green-600 flex items-center justify-center">
                        <img src="{{ asset('p-logo.png') }}" alt="PINACARE" class="w-5 h-5">
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-gray-800">Eco-Friendly</p>
                        <p class="text-[10px] text-gray-500">Plant-based fibres</p>
                    </div>
                </div>
                <div class="absolute bottom-16 -right-4 bg-white/95 backdrop-blur rounded-2xl px-4 py-3 shadow-xl flex items-center gap-3 float" style="animation-delay: 1.2s">
                    <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                        @include('storefront.partials.icons', ['icon' => 'recycle', 'class' => 'w-5 h-5'])
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-gray-800">Circular Economy</p>
                        <p class="text-[10px] text-gray-500">Zero-waste system</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave divider --}}
    <div class="absolute bottom-0 left-0 right-0 leading-none text-[#faf8f3]">
        <svg viewBox="0 0 1440 100" fill="currentColor" preserveAspectRatio="none" class="w-full h-16 md:h-24">
            <path d="M0,64L48,58.7C96,53,192,43,288,48C384,53,480,75,576,80C672,85,768,75,864,64C960,53,1056,43,1152,42.7C1248,43,1344,53,1392,58.7L1440,64L1440,100L0,100Z"></path>
        </svg>
    </div>
</section>

{{-- ============================================================
     2. ABOUT / WHO WE ARE — Split layout with story & stats
============================================================= --}}
<section class="py-20 md:py-28 bg-[#faf8f3]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            {{-- Left: visual story --}}
            <div class="relative order-2 lg:order-1">
                <div class="rounded-3xl overflow-hidden shadow-2xl border-8 border-white">
                    <img src="{{ asset('Medium (Front view).png') }}" alt="Happy baby with PINACARE" class="w-full h-[420px] object-cover">
                </div>
                {{-- Floating stat card --}}
                <div class="absolute -bottom-8 left-6 md:left-10 bg-green-700 text-white rounded-2xl px-6 py-5 shadow-xl">
                    <p class="text-3xl font-extrabold">{{ number_format($impact?->diapers_saved ?? 120000) }}+</p>
                    <p class="text-xs text-green-100 mt-1">Diapers Saved from Landfills</p>
                </div>
                <div class="absolute -top-6 right-4 md:right-8 bg-white rounded-2xl px-5 py-4 shadow-xl border border-green-100">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                            @include('storefront.partials.icons', ['icon' => 'pineapple', 'class' => 'w-5 h-5'])
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-gray-800">Pineapple Leaf</p>
                            <p class="text-[10px] text-gray-500">To Baby Comfort</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: content --}}
            <div class="order-1 lg:order-2">
                <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full mb-5">Who We Are</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">From Pineapple Leaf to <span class="text-green-700">Baby Comfort</span></h2>
                <p class="mt-5 text-gray-600 leading-relaxed text-lg">
                    PINACARE was born from a simple belief: the products that touch your baby's skin should never harm the planet. We turn agricultural waste — pineapple leaves — into ultra-soft, hypoallergenic, fully biodegradable diapers and wipes.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Every purchase supports East African farmers, creates green jobs, and keeps thousands of nappies out of landfills.
                </p>

                {{-- Value props --}}
                <div class="mt-8 grid sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3 bg-white rounded-2xl p-4 shadow-sm border border-green-50">
                        <div class="w-11 h-11 rounded-xl bg-green-100 text-green-700 flex items-center justify-center flex-shrink-0">
                            @include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-6 h-6'])
                        </div>
                        <div>
                            <p class="font-extrabold text-gray-800 text-sm">100% Biodegradable</p>
                            <p class="text-xs text-gray-500 mt-1">Decomposes naturally, no harmful chemicals.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-white rounded-2xl p-4 shadow-sm border border-blue-50">
                        <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                            @include('storefront.partials.icons', ['icon' => 'baby', 'class' => 'w-6 h-6'])
                        </div>
                        <div>
                            <p class="font-extrabold text-gray-800 text-sm">Gentle on Skin</p>
                            <p class="text-xs text-gray-500 mt-1">Dermatologist-tested, rash-free comfort.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-white rounded-2xl p-4 shadow-sm border border-amber-50">
                        <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0">
                            @include('storefront.partials.icons', ['icon' => 'farmer', 'class' => 'w-6 h-6'])
                        </div>
                        <div>
                            <p class="font-extrabold text-gray-800 text-sm">Farmer Empowered</p>
                            <p class="text-xs text-gray-500 mt-1">Fair wages &amp; rural community support.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                            @include('storefront.partials.icons', ['icon' => 'recycle', 'class' => 'w-6 h-6'])
                        </div>
                        <div>
                            <p class="font-extrabold text-gray-800 text-sm">Circular Economy</p>
                            <p class="text-xs text-gray-500 mt-1">Compost &amp; renew — zero waste loop.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap items-center gap-6">
                    <a href="{{ route('store.about') }}" class="inline-flex items-center px-7 py-3.5 bg-green-700 text-white font-bold rounded-full hover:bg-green-800 transition shadow-lg">
                        Our Full Story
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <div class="flex -space-x-2">
                            <span class="w-8 h-8 rounded-full bg-green-200 border-2 border-white"></span>
                            <span class="w-8 h-8 rounded-full bg-emerald-200 border-2 border-white"></span>
                            <span class="w-8 h-8 rounded-full bg-teal-200 border-2 border-white"></span>
                        </div>
                        <span><strong class="text-gray-800">{{ number_format($impact?->farmers_supported ?? 350) }}+</strong> farmers supported</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     3. PRODUCTS & CATEGORIES — Category cards + filterable grid
============================================================= --}}
<section class="py-20 md:py-24 bg-green-800 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-green-200 text-xs font-extrabold tracking-widest uppercase rounded-full mb-5">Featured Products</span>
            <h2 class="text-3xl md:text-4xl font-extrabold">Eco-Friendly Baby Care</h2>
            <p class="text-green-200 text-lg mt-2">Biodegradable diapers &amp; wipes made from pineapple leaf fibres.</p>
        </div>

        {{-- Filterable product grid --}}
        @if($featuredProducts->count())
        <div class="mb-8 flex flex-wrap items-center justify-center gap-2">
            <button type="button" data-filter="all" class="px-5 py-2 rounded-full text-sm font-bold bg-green-700 text-white transition">All</button>
            @foreach(['diaper' => 'Diapers', 'wipe' => 'Wipes', 'bundle' => 'Bundles'] as $key => $label)
            <button type="button" data-filter="{{ $key }}" class="px-5 py-2 rounded-full text-sm font-bold bg-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-700 transition">{{ $label }}</button>
            @endforeach
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($featuredProducts as $product)
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

        <div class="text-center mt-10">
            <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-white-700 text-white-700 font-extrabold rounded-full hover:bg-white-700 hover:text-white transition">
                View All Products
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ============================================================
     IMPACT STRIP — Between sections (data-driven)
============================================================= --}}
@if($impact)
<div class="py-12 md:py-16 bg-green-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <p class="text-3xl font-extrabold">{{ number_format($impact->diapers_saved) }}+</p>
                <p class="text-sm mt-1">Diapers Saved from Landfills</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold">{{ number_format($impact->farmers_supported) }}+</p>
                <p class="text-sm mt-1">Farmers Supported</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold">{{ number_format($impact->jobs_created) }}+</p>
                <p class="text-sm mt-1">Green Jobs Created</p>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ============================================================
4. TESTIMONIALS
============================================================= --}}
@if($testimonials->count())
<section class="py-20 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-sm font-semibold text-green-700">
                Testimonials
            </span>

            <h2 class="mt-4 text-4xl font-extrabold text-gray-900">
                Loved by Parents Across Kenya
            </h2>

            <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                Thousands of parents trust PINACARE for safe, sustainable baby products.
            </p>
        </div>

        <div class="relative">
            {{-- Previous --}}
            <button id="prevTestimonial"
                class="absolute left-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white shadow-lg hover:bg-green-600 hover:text-white transition">
                ←
            </button>
            {{-- Next --}}
            <button id="nextTestimonial"
                class="absolute right-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white shadow-lg hover:bg-green-600 hover:text-white transition">
                →
            </button>
            <div class="overflow-hidden">
                <div id="testimonialTrack"
                     class="flex transition-transform duration-500 ease-in-out">

                    @foreach($testimonials as $testimonial)
                    <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 p-4">
                        <div
                            class="bg-white rounded-3xl border border-gray-100 shadow-lg hover:shadow-2xl transition duration-300 p-8 h-full flex flex-col">
                            {{-- Quote --}}
                            <div
                                class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-green-700"
                                     fill="currentColor"
                                     viewBox="0 0 24 24">
                                    <path d="M7.17 6A5.001 5.001 0 002 11v7h7v-7H5.08A3.003 3.003 0 017.17 8H9V6H7.17zm10 0A5.001 5.001 0 0012 11v7h7v-7h-3.92A3.003 3.003 0 0117.17 8H19V6h-1.83z"/>
                                </svg>
                            </div>

                            {{-- Review --}}
                            <p class="text-gray-600 leading-7 flex-grow italic">
                                "{{ $testimonial->content }}"
                            </p>

                            {{-- Stars --}}
                            <div class="flex mt-6 mb-5">
                                @for($i=1;$i<=5;$i++)
                                    <svg
                                        class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-yellow-400':'text-gray-300' }}"
                                        fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            {{-- Customer --}}
                            <div class="flex items-center mt-auto">
                                <div
                                    class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
                                    @include('storefront.partials.icons',[
                                        'icon'=>'avatar',
                                        'class'=>'w-7 h-7 text-green-700'
                                    ])
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-bold text-gray-900">
                                        {{ $testimonial->customer?->name ?? 'Verified Parent' }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        Verified Customer
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Indicators --}}
            <div class="flex justify-center mt-10 gap-3">
                @foreach($testimonials as $i => $testimonial)
                    <button
                        data-slide="{{ $i }}"
                        class="testimonial-dot h-3 rounded-full transition-all duration-300 {{ $i==0 ? 'w-8 bg-green-700':'w-3 bg-gray-300' }}">
                    </button>
                @endforeach
            </div>
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('store.community') }}"
               class="inline-flex items-center px-8 py-3 rounded-full bg-green-700 text-white font-semibold hover:bg-green-800 transition">
                More Reviews
            </a>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     5. NEWSLETTER CTA — Split gradient card with benefits
============================================================= --}}
{{-- ============================================================
5. NEWSLETTER CTA
============================================================= --}}
<section class="relative overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-800 text-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="max-w-4xl mx-auto text-center">

            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/15 mb-6">
                @include('storefront.partials.icons', [
                    'icon' => 'email',
                    'class' => 'w-8 h-8 text-white'
                ])
            </div>

            <h2 class="text-4xl font-extrabold text-white">
                Join the PINACARE Family
            </h2>

            <p class="mt-4 text-green-100 text-lg">
                Subscribe to receive eco-parenting tips, exclusive offers and new product updates.
            </p>

            <form method="POST"
                  action="{{ route('store.newsletter') }}"
                  class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">

                @csrf

                <input
                    type="email"
                    name="email"
                    placeholder="Your Email Address"
                    required
                    class="flex-1 max-w-xl px-6 py-4 rounded-full border-0 focus:ring-4 focus:ring-green-300 text-gray-700">

                <button
                    type="submit"
                    class="px-10 py-4 rounded-full bg-white text-green-700 font-bold hover:bg-green-100 transition">

                    Subscribe

                </button>

            </form>

            <div class="flex flex-wrap justify-center gap-8 mt-8 text-green-100 text-sm">

                <div class="flex items-center gap-2">
                    ✔ Eco Parenting Tips
                </div>

                <div class="flex items-center gap-2">
                    ✔ Exclusive Discounts
                </div>

                <div class="flex items-center gap-2">
                    ✔ New Product Alerts
                </div>

            </div>

            <p class="mt-6 text-xs text-green-200">
                We respect your privacy. Unsubscribe anytime.
            </p>

        </div>

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

    // Category filter
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', function(){
            const filter = this.dataset.filter;
            document.querySelectorAll('[data-filter]').forEach(b => {
                b.classList.remove('bg-green-700', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-600');
            });
            this.classList.add('bg-green-700', 'text-white');
            this.classList.remove('bg-gray-100', 'text-gray-600');

            document.querySelectorAll('.product-card').forEach(card => {
                if(filter === 'all' || card.dataset.category === filter){
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });

    // Testimonial carousel
    const track = document.getElementById('testimonialTrack');
    if (track) {
        const slides = track.children.length;
        let index = 0;
        const dots = document.querySelectorAll('.testimonial-dot');

        function goTo(i){
            index = (i + slides) % slides;
            track.style.transform = 'translateX(-' + (index * 100) + '%)';
            dots.forEach((d, di) => {
                d.classList.toggle('bg-green-700', di === index);
                d.classList.toggle('bg-gray-300', di !== index);
                d.classList.toggle('w-6', di === index);
                d.classList.toggle('w-2.5', di !== index);
            });
        }

        document.getElementById('nextTestimonial')?.addEventListener('click', () => goTo(index + 1));
        document.getElementById('prevTestimonial')?.addEventListener('click', () => goTo(index - 1));
        dots.forEach(d => d.addEventListener('click', () => goTo(parseInt(d.dataset.slide))));

        // Autoplay
        setInterval(() => goTo(index + 1), 6000);
    }
</script>
@endpush

