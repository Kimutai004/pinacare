@extends('storefront.layouts.app')
@section('title', 'About Us')

@section('content')
{{-- ===== 1. HERO — Watercolor story banner with wave ===== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-800 text-white">
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-green-400/20 blur-3xl"></div>
    <div class="absolute bottom-0 -left-20 w-72 h-72 rounded-full bg-emerald-300/20 blur-3xl"></div>
    <div class="relative max-w-4xl mx-auto px-4 text-center py-16 md:py-24">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-green-200 text-xs font-bold tracking-widest uppercase rounded-full mb-6">
            <span class="text-green-300">@include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-4 h-4'])</span>
            Our Story
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">From Pineapple Leaf to <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-emerald-200">Baby Comfort</span></h1>
        <p class="text-green-100 mt-4 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">We're building a circular economy that nurtures babies and protects the planet — turning agricultural waste into gentle, sustainable baby care.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none text-[#faf8f3]">
        <svg viewBox="0 0 1440 80" fill="currentColor" preserveAspectRatio="none" class="w-full h-12 md:h-16">
            <path d="M0,48L60,42.7C120,37,240,27,360,29.3C480,32,600,48,720,53.3C840,59,960,53,1080,45.3C1200,37,1320,27,1380,213L1440,16L1440,80L0,80Z"></path>
        </svg>
    </div>
</section>

{{-- ===== 2. VISION & MISSION — Split feature cards ===== --}}
<section class="py-16 md:py-20 bg-[#faf8f3]">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-8">
            {{-- Vision --}}
            <div class="group relative overflow-hidden bg-white rounded-[2rem] p-10 shadow-sm border border-green-50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-green-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white flex items-center justify-center shadow-lg shadow-green-500/30">
                        @include('storefront.partials.icons', ['icon' => 'vision', 'class' => 'w-8 h-8'])
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 mt-6">Our Vision</h2>
                    <p class="text-gray-600 mt-4 leading-relaxed text-lg">A circular economy future where no child's comfort comes at the cost of the planet.</p>
                    <div class="mt-6 inline-flex items-center gap-2 text-green-700 font-bold text-sm">
                        <span class="w-2 h-2 rounded-full bg-green-600"></span> Health · Prosperity · Planet
                    </div>
                </div>
            </div>
            {{-- Mission --}}
            <div class="group relative overflow-hidden bg-white rounded-[2rem] p-10 shadow-sm border border-blue-50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-blue-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/30">
                        @include('storefront.partials.icons', ['icon' => 'target', 'class' => 'w-8 h-8'])
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 mt-6">Our Mission</h2>
                    <p class="text-gray-600 mt-4 leading-relaxed text-lg">To design and produce affordable, biodegradable diapers from pineapple leaf fiber that protect children's health, reduce waste and create green jobs.</p>
                    <div class="mt-6 inline-flex items-center gap-2 text-blue-700 font-bold text-sm">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Affordable · Sustainable · Safe
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 3. JOURNEY — Horizontal timeline ===== --}}
<section class="py-16 md:py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full mb-5">How It's Made</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">From Pineapple Leaf to Baby Comfort</h2>
            <p class="text-gray-600 mt-3 text-lg">Four simple steps. One beautiful circular story.</p>
        </div>

        <div class="relative">
            {{-- Connecting line --}}
            <div class="hidden lg:block absolute top-16 left-10 right-10 h-1 bg-gradient-to-r from-green-200 via-emerald-300 to-green-200 rounded-full"></div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $steps = [
                        ['icon' => 'pineapple', 'num' => '01', 'title' => 'Harvest', 'desc' => 'Farmers collect pineapple leaves after harvest, turning agricultural waste into a valuable resource.', 'color' => 'from-green-500 to-emerald-600', 'ring' => 'ring-green-100'],
                        ['icon' => 'thread', 'num' => '02', 'title' => 'Extract Fibers', 'desc' => 'Strong, ultra-soft natural fibers are extracted and processed without any harmful chemicals.', 'color' => 'from-emerald-500 to-teal-600', 'ring' => 'ring-emerald-100'],
                        ['icon' => 'diaper', 'num' => '03', 'title' => 'Craft Diapers', 'desc' => 'Fibers are woven into ultra-soft, absorbent, fully biodegradable baby diapers.', 'color' => 'from-teal-500 to-cyan-600', 'ring' => 'ring-teal-100'],
                        ['icon' => 'recycle', 'num' => '04', 'title' => 'Compost & Renew', 'desc' => 'Used diapers break down naturally, completing the circular economy loop.', 'color' => 'from-cyan-500 to-sky-600', 'ring' => 'ring-cyan-100'],
                    ];
                @endphp
                @foreach($steps as $i => $step)
                <div class="relative text-center group">
                    <div class="relative mx-auto w-32 h-32 rounded-full bg-gradient-to-br {{ $step['color'] }} ring-8 {{ $step['ring'] }} flex items-center justify-center text-white shadow-xl group-hover:scale-105 transition-transform duration-300">
                        <span class="w-12 h-12">@include('storefront.partials.icons', ['icon' => $step['icon'], 'class' => 'w-full h-full'])</span>
                        <span class="absolute -top-2 -right-2 w-9 h-9 rounded-full bg-white text-green-700 font-extrabold text-sm flex items-center justify-center border-2 border-green-100 shadow">{{ $step['num'] }}</span>
                    </div>
                    <h3 class="font-extrabold text-gray-800 mt-5 text-lg">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== 4. SDG CONTRIBUTION — Gradient cards ===== --}}
<section class="py-16 md:py-24 bg-green-50/50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 bg-white text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full border border-green-200 mb-5">Global Goals</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Our Contribution to the SDGs</h2>
            <p class="text-gray-600 mt-3 text-lg">Aligned with the United Nations Sustainable Development Goals</p>
        </div>

        <div class="grid md:grid-cols-3 gap-7">
            @php
                $sdgs = [
                    ['num' => '3', 'title' => 'Good Health & Well-Being', 'desc' => 'Dermatologist-tested, hypoallergenic products keep babies healthy and rash-free.', 'grad' => 'from-red-500 to-rose-600', 'icon' => 'heart'],
                    ['num' => '12', 'title' => 'Responsible Consumption', 'desc' => 'Biodegradable materials reduce landfill waste and promote circular consumption.', 'grad' => 'from-green-500 to-emerald-600', 'icon' => 'recycle'],
                    ['num' => '13', 'title' => 'Climate Action', 'desc' => 'Reduced carbon emissions through sustainable sourcing and local production.', 'grad' => 'from-blue-500 to-cyan-600', 'icon' => 'globe'],
                ];
            @endphp
            @foreach($sdgs as $sdg)
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $sdg['grad'] }}"></div>
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $sdg['grad'] }} text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <span class="w-8 h-8">@include('storefront.partials.icons', ['icon' => $sdg['icon'], 'class' => 'w-full h-full'])</span>
                        </div>
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full {{ $sdg['grad'] }} text-white font-extrabold text-lg shadow">{{ $sdg['num'] }}</span>
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-xl mt-5">{{ $sdg['title'] }}</h3>
                    <p class="text-gray-600 mt-3 leading-relaxed">{{ $sdg['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 5. VALUES — Icon list ===== --}}
<section class="py-16 md:py-20 bg-white">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">What We Stand For</h2>
        <p class="text-gray-600 mt-3 text-lg">The principles that guide every decision we make.</p>
        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @php
                $values = [
                    ['icon' => 'leaf', 'title' => 'Sustainability', 'desc' => 'Where no child\'s comfort comes at the cost of the planet.'],
                    ['icon' => 'baby', 'title' => 'Baby Safety', 'desc' => 'Gentle, pure & hypoallergenic'],
                    ['icon' => 'bulb', 'title' => 'Innovation', 'desc' => 'Pioneering sustainable solutions'],
                    ['icon' => 'coins', 'title' => 'Affordability', 'desc' => 'Quality care for every family'],
                    ['icon' => 'people', 'title' => 'Community Empowerment', 'desc' => 'Creating opportunities for farmers'],
                ];
            @endphp
            @foreach($values as $value)
            <div class="group bg-green-50 rounded-2xl p-6 border border-green-100 hover:bg-green-100/60 hover:border-green-200 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-white text-green-700 shadow-sm flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => $value['icon'], 'class' => 'w-6 h-6'])
                </div>
                <h3 class="font-extrabold text-gray-800 mt-4">{{ $value['title'] }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $value['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 6. STATS BAND ===== --}}
<section class="bg-gradient-to-r from-green-800 to-emerald-800 text-white py-14">
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @php
                $stats = [
                    ['val' => '100%', 'label' => 'Biodegradable'],
                    ['val' => '0', 'label' => 'Harmful Chemicals'],
                    ['val' => '500+', 'label' => 'Farmers Supported'],
                    ['val' => '4.9★', 'label' => 'Parent Rating'],
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="border-l-2 border-green-400/40 pl-4 text-left">
                <p class="text-3xl md:text-4xl font-extrabold">{{ $stat['val'] }}</p>
                <p class="text-green-100/80 text-sm mt-1">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 7. CTA ===== --}}
<section class="py-16 md:py-20 bg-[#faf8f3]">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-green-700 to-emerald-900 text-white p-10 md:p-14 shadow-2xl">
            <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-green-400/20 blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-emerald-300/20 blur-3xl"></div>
            <div class="relative">
                <h2 class="text-3xl md:text-4xl font-extrabold">Be Part of the Change</h2>
                <p class="text-green-100 mt-3 text-lg">Every diaper you choose makes a difference.</p>
                <a href="{{ route('store.shop') }}" class="group inline-flex items-center gap-2 mt-8 px-8 py-4 bg-white text-green-700 font-extrabold rounded-full hover:bg-green-50 transition shadow-lg">
                    Shop Our Products
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:translate-x-1 transition"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
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

