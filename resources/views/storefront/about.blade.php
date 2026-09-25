@extends('storefront.layouts.app')
@section('title', 'About Us')
@section('meta_description', 'Meet PINACARE — a Kenyan eco-innovation venture turning pineapple leaf fibre into 100% biodegradable diapers and wipes. Our story, vision, values and impact.')
@section('meta_keywords', 'about PINACARE, pineapple leaf fibre diapers, biodegradable baby care Kenya, circular economy baby products, sustainable nappies company')
@section('og_image', asset('pinacare.jpeg'))

@push('head')
<script>document.documentElement.classList.add('reveal-ready');</script>
@endpush

@section('content')
{{-- ============ 1. HERO ============ --}}

<section class="relative overflow-hidden bg-[#0b3d2e] text-white">

    <div class="absolute -top-24 -right-24 w-80 h-80 bg-green-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-4xl mx-auto px-4 text-center py-20 md:py-28">

        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 border border-white/20 text-green-200 text-xs font-extrabold uppercase tracking-widest rounded-full mb-6">

            <span class="text-green-300">@include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-4 h-4'])</span>

            Our Story

        </span>

        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">From Pineapple Leaf to <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-emerald-200">Baby Comfort</span></h1>

        <p class="text-green-100 text-lg md:text-xl mt-5 max-w-2xl mx-auto leading-relaxed">We're building a circular economy that nurtures babies and protects the planet â€” turning agricultural waste into gentle, sustainable baby care.</p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">

            <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-green-800 font-extrabold rounded-full shadow-lg hover:bg-green-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-700 focus-visible:ring-offset-2 transition">

                Shop Our Products

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:translate-x-0.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>

            </a>

            <a href="{{ route('store.impact') }}" class="inline-flex items-center gap-2 px-7 py-3.5 border border-white/40 text-white font-bold rounded-full hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 transition">

                Our Impact

            </a>

        </div>

    </div>

    <div class="absolute bottom-0 left-0 right-0 leading-none text-[#faf8f3]">

        <svg viewBox="0 0 1440 80" fill="currentColor" preserveAspectRatio="none" class="w-full h-12 md:h-16">

            <path d="M0,48L60,42.7C120,37,240,27,360,29.3C480,32,600,48,720,53.3C840,59,960,53,1080,45.3C1200,37,1320,27,1380,213L1440,16L1440,80L0,80Z"></path>

        </svg>

    </div>

</section>


{{-- ============================================================
     2. OUR STORY — narrative, pull quote and collage
============================================================= --}}
<section id="story" class="py-20 md:py-28 bg-[#faf8f3]" aria-labelledby="story-title">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            {{-- Visual collage --}}
            <div class="relative reveal">
                <div class="rounded-3xl overflow-hidden shadow-2xl border-8 border-white">
                    <img src="https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?ixlib=rb-4.0.3&auto=format&fit=crop&w=900&q=80"
                         alt="Parent holding a happy baby"
                         width="900" height="600"
                         loading="lazy" decoding="async"
                         class="w-full h-[420px] object-cover">
                </div>

                @if($impact)
                <div class="absolute -bottom-8 left-6 md:left-10 bg-green-700 text-white rounded-2xl px-6 py-5 shadow-xl">
                    <p class="text-3xl font-extrabold"><span data-count="{{ (int) $impact->diapers_saved }}">{{ number_format($impact->diapers_saved) }}</span>+</p>
                    <p class="text-xs text-green-100 mt-1">Diapers kept out of landfill</p>
                </div>
                @endif

                <div class="absolute -top-6 right-4 md:right-8 bg-white rounded-2xl px-5 py-4 shadow-xl border border-green-100 flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full overflow-hidden border border-green-100 shrink-0">
                        <img src="{{ asset('p-logo.png') }}" alt="PINACARE logo" width="40" height="40" loading="lazy" class="w-full h-full object-cover">
                    </span>
                    <div>
                        <p class="text-xs font-extrabold text-gray-800">Pineapple Leaf</p>
                        <p class="text-[10px] text-gray-500">To baby comfort</p>
                    </div>
                </div>
            </div>

            {{-- Narrative --}}
            <div class="reveal">
                <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full mb-5">Who We Are</span>
                <h2 id="story-title" class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">Driven by purpose, <span class="text-green-700">powered by nature</span></h2>
                <p class="mt-5 text-gray-600 leading-relaxed text-lg">
                    PINACARE was born from a simple belief: the products that touch your baby's skin should never harm the planet. Across Kenya, pineapple farmers harvest their crop and leave behind mountains of leaves. Instead of letting that waste burn or rot, we collect it.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Those leaves become a soft, absorbent natural fibre &mdash; crafted into diapers and wipes that are hypoallergenic, chemical-free and fully compostable. Every purchase pays farmers fairly, creates green jobs and keeps thousands of nappies out of landfill.
                </p>

                <blockquote class="mt-8 border-l-4 border-green-500 bg-white rounded-r-2xl px-6 py-5 shadow-sm">
                    <p class="text-lg font-semibold text-gray-800 leading-relaxed">&ldquo;A circular economy that nurtures babies and protects the planet &mdash; one nappy at a time.&rdquo;</p>
                    <footer class="mt-3 text-sm font-bold text-green-700">&mdash; The PINACARE Team</footer>
                </blockquote>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('store.community') }}" class="inline-flex items-center px-6 py-3 bg-green-700 text-white font-bold rounded-full hover:bg-green-800 transition shadow-lg">
                        Read Our Journal
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('store.partners') }}" class="inline-flex items-center px-6 py-3 border-2 border-green-700 text-green-700 font-bold rounded-full hover:bg-green-700 hover:text-white transition">
                        Healthcare Partnerships
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     3. VISION & MISSION — two pillars plus the triple bottom line
============================================================= --}}
<section id="vision-mission" class="py-20 md:py-28 bg-white" aria-labelledby="vision-mission-title">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto reveal">
            <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full">Our Direction</span>
            <h2 id="vision-mission-title" class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-5">Purpose in every layer</h2>
            <p class="text-gray-600 text-lg mt-4 leading-relaxed">Two simple ideas guide everything we do: protect every baby, and never at the planet's expense.</p>
        </div>

        <div class="mt-14 grid lg:grid-cols-2 gap-8">
            <article class="reveal group relative bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 md:p-10 border border-green-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => 'vision', 'class' => 'w-7 h-7'])
                </div>
                <span class="mt-6 block text-xs font-extrabold uppercase tracking-widest text-green-700">Our Vision</span>
                <p class="mt-4 text-gray-600 leading-relaxed">A world where no child's comfort comes at the cost of the planet, where the waste of one harvest becomes the comfort of the next generation.</p>
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-white text-green-700 text-xs font-bold rounded-full border border-green-100">Zero waste</span>
                    <span class="px-3 py-1 bg-white text-green-700 text-xs font-bold rounded-full border border-green-100">Renewable materials</span>
                </div>
            </article>

            <article class="reveal group relative bg-gradient-to-br from-blue-50 to-cyan-50 rounded-3xl p-8 md:p-10 border border-blue-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => 'target', 'class' => 'w-7 h-7'])
                </div>
                <span class="mt-6 block text-xs font-extrabold uppercase tracking-widest text-blue-700">Our Mission</span>
                <p class="mt-4 text-gray-600 leading-relaxed">To design and produce affordable diapers and wipes from pineapple leaf fibre that protect children's health, reduce waste and create green jobs across East Africa.</p>
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-white text-blue-700 text-xs font-bold rounded-full border border-blue-100">Affordable</span>
                    <span class="px-3 py-1 bg-white text-blue-700 text-xs font-bold rounded-full border border-blue-100">Sustainable</span>
                    <span class="px-3 py-1 bg-white text-blue-700 text-xs font-bold rounded-full border border-blue-100">Safe</span>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- ============================================================
     4. BY THE NUMBERS — live impact counters
============================================================= --}}
<section id="numbers" class="relative overflow-hidden py-16 md:py-20 bg-gradient-to-r from-green-800 to-emerald-800 text-white" aria-labelledby="numbers-title">
    <div class="absolute -top-24 right-0 w-72 h-72 rounded-full bg-green-400/10 blur-3xl pointer-events-none"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto reveal">
            <h2 id="numbers-title" class="text-3xl md:text-4xl font-extrabold">Our impact in numbers</h2>
            <p class="text-green-100 text-lg mt-4">Live figures from the farms, our workshop and every family who chooses PINACARE.</p>
        </div>

        @php
            $statTiles = [];

            if ($impact) {
                $statTiles[] = ['value' => (int) $impact->diapers_saved, 'decimals' => 0, 'suffix' => '+', 'label' => 'Diapers saved from landfill', 'icon' => 'diaper'];
                $statTiles[] = ['value' => (float) $impact->co2_reduced, 'decimals' => 1, 'suffix' => ' kg', 'label' => 'CO2 emissions reduced', 'icon' => 'co2'];
                $statTiles[] = ['value' => (int) $impact->farmers_supported, 'decimals' => 0, 'suffix' => '+', 'label' => 'Farming families supported', 'icon' => 'farmer'];
            }

            $statTiles[] = ['value' => 100, 'decimals' => 0, 'suffix' => '%', 'label' => 'Biodegradable materials', 'icon' => 'recycle'];
            $statTiles[] = ['value' => 0, 'decimals' => 0, 'suffix' => '', 'label' => 'Harmful chemicals used', 'icon' => 'leaf'];
        @endphp

        <div class="mt-12 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 text-center">
            @foreach($statTiles as $tile)
            <div class="reveal bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition">
                <div class="w-11 h-11 rounded-xl bg-white/10 text-green-200 flex items-center justify-center mx-auto mb-4">
                    @include('storefront.partials.icons', ['icon' => $tile['icon'], 'class' => 'w-6 h-6'])
                </div>
                <p class="text-3xl md:text-4xl font-extrabold tabular-nums leading-none">
                    <span data-count="{{ $tile['value'] }}" data-decimals="{{ $tile['decimals'] }}">{{ number_format($tile['value'], $tile['decimals']) }}</span>{{ $tile['suffix'] }}
                </p>
                <p class="text-green-100 text-sm mt-3 leading-snug">{{ $tile['label'] }}</p>
            </div>
            @endforeach
        </div>

        <p class="text-center mt-10 reveal">
            <a href="{{ route('store.impact') }}" class="inline-flex items-center gap-2 text-green-200 font-bold hover:text-white transition">
                See the full impact report
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </p>
    </div>
</section>

{{-- ============================================================
     5. HOW IT WORKS — the circular journey
============================================================= --}}
<section id="journey" class="py-20 md:py-28 bg-white" aria-labelledby="journey-title">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto reveal">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-100 text-green-800 text-xs font-extrabold uppercase tracking-widest rounded-full">
                <span class="text-green-700">@include('storefront.partials.icons', ['icon' => 'recycle', 'class' => 'w-4 h-4'])</span>
                How It Works
            </span>
            <h2 id="journey-title" class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-5">From pineapple leaf to baby comfort</h2>
            <p class="text-gray-600 text-lg mt-4 leading-relaxed">Four steps that close the loop between farm waste and your baby's nursery.</p>
        </div>

        <div class="relative mt-14">
            <div class="hidden lg:block absolute top-7 left-[12.5%] right-[12.5%] border-t-2 border-dashed border-green-200" aria-hidden="true"></div>

            <div class="relative grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $steps = [
                        ['icon' => 'pineapple', 'num' => '01', 'title' => 'Harvest', 'desc' => 'Farmers collect pineapple leaves after harvest, turning agricultural waste into a valuable resource.', 'color' => 'from-green-500 to-emerald-600'],
                        ['icon' => 'thread', 'num' => '02', 'title' => 'Extract Fibre', 'desc' => 'Strong, ultra-soft natural fibre is extracted and processed without any harmful chemicals.', 'color' => 'from-emerald-500 to-teal-600'],
                        ['icon' => 'diaper', 'num' => '03', 'title' => 'Craft Diapers', 'desc' => 'Fibre is woven into ultra-soft, absorbent, fully biodegradable diapers and wipes.', 'color' => 'from-teal-500 to-cyan-600'],
                        ['icon' => 'recycle', 'num' => '04', 'title' => 'Compost & Renew', 'desc' => 'Used diapers break down naturally, feeding the soil and completing the loop.', 'color' => 'from-cyan-500 to-sky-600'],
                    ];
                @endphp

                @foreach($steps as $step)
                <article class="reveal group relative text-center">
                    <div class="relative mx-auto w-14 h-14 rounded-2xl bg-gradient-to-br {{ $step['color'] }} text-white flex items-center justify-center shadow-lg ring-4 ring-white group-hover:scale-110 transition-transform">
                        @include('storefront.partials.icons', ['icon' => $step['icon'], 'class' => 'w-7 h-7'])
                    </div>
                    <span class="mt-4 inline-block text-xs font-extrabold tracking-[0.2em] text-green-600">STEP {{ $step['num'] }}</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mt-2">{{ $step['title'] }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mt-3">{{ $step['desc'] }}</p>
                </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============ 6. SDG CONTRIBUTION ============ --}}

<section id="sdg" class="py-16 md:py-24 bg-[#faf8f3]" aria-labelledby="sdg-title">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto">

            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white border border-green-200 text-green-800 text-xs font-extrabold uppercase tracking-[0.16em] rounded-full">

                <span class="relative flex h-2 w-2">

                    <span class="absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75 animate-ping"></span>

                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-600"></span>

                </span>

                Global Goals

            </span>

            <h2 id="sdg-title" class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-5">Our Contribution to the <span class="text-green-700">SDGs</span></h2>

            <p class="text-gray-600 text-base sm:text-lg mt-5 max-w-2xl mx-auto leading-relaxed">Our work contributes to the United Nations Sustainable Development Goals through healthier products, responsible production and sustainable innovation.</p>

        </div>



        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @php

                $sdgs = [

                    ['num' => '03', 'title' => 'Good Health & Well-Being', 'desc' => 'Dermatologist-tested, hypoallergenic products designed to support healthier, safer and more comfortable lives for babies.', 'icon' => 'SDG 3.png', 'color' => '#4C9F38'],

                    ['num' => '09', 'title' => 'Industry, Innovation & Infrastructure', 'desc' => 'We promote innovative manufacturing and biodegradable materials while building local production capacity and expertise.', 'icon' => 'SDG 9.png', 'color' => '#FD6925'],

                    ['num' => '12', 'title' => 'Responsible Consumption & Production', 'desc' => 'Biodegradable materials help reduce waste and encourage more responsible approaches to production and consumption.', 'icon' => 'SDG 12.png', 'color' => '#BF8B2E'],

                    ['num' => '13', 'title' => 'Climate Action', 'desc' => 'Sustainable sourcing and local production contribute to reducing environmental impact and supporting climate-conscious practices.', 'icon' => 'SDG 13.png', 'color' => '#3F7E44'],

                    ['num' => '15', 'title' => 'Life on Land', 'desc' => 'Responsible pineapple leaf fibre sourcing supports sustainable agriculture, better resource use and protection of terrestrial ecosystems.', 'icon' => 'SDG 15.png', 'color' => '#56C02B'],

                ];

            @endphp

            @foreach($sdgs as $sdg)

            <article class="relative group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300 overflow-hidden">

                <div class="h-1.5 w-full" style="background-color: {{ $sdg['color'] }};"></div>

                <div class="p-6 sm:p-7">

                    <div class="flex items-start gap-4">

                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden shrink-0 shadow-sm border border-gray-100">

                            <img src="{{ asset($sdg['icon']) }}" alt="United Nations Sustainable Development Goal {{ $sdg['num'] }} - {{ $sdg['title'] }}" class="w-full h-full object-cover" loading="lazy">

                        </div>

                        <div class="min-w-0">

                            <span class="block text-[10px] font-extrabold uppercase tracking-[0.14em]" style="color: {{ $sdg['color'] }};">Sustainable Development Goal</span>

                            <h3 class="text-lg font-extrabold text-gray-900 mt-2 leading-snug">{{ $sdg['title'] }}</h3>

                        </div>

                    </div>

                    <p class="mt-4 text-sm leading-relaxed text-gray-600">{{ $sdg['desc'] }}</p>

                    <div class="mt-5 flex items-center justify-between">

                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400">SDG {{ $sdg['num'] }}</span>

                        <span class="flex items-center justify-center w-9 h-9 rounded-full text-white" style="background-color: {{ $sdg['color'] }};">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>

                        </span>

                    </div>

                </div>

                <div class="absolute inset-x-0 bottom-0 h-1 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left" style="background-color: {{ $sdg['color'] }};"></div>

            </article>

            @endforeach

        </div>

    </div>

</section>



{{-- ============================================================
     7. VALUES — what matters to us
============================================================= --}}
<section id="values" class="py-20 md:py-28 bg-white" aria-labelledby="values-title">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto reveal">
            <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full">What Matters to Us</span>
            <h2 id="values-title" class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-5">The values behind every diaper</h2>
            <p class="text-gray-600 text-lg mt-4 leading-relaxed">From our farmers to your family &mdash; these principles guide every decision we make.</p>
        </div>

        <div class="mt-14 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
            @php
                $values = [
                    ['icon' => 'leaf', 'title' => 'Sustainability', 'desc' => "No child's comfort comes at the cost of the planet."],
                    ['icon' => 'baby', 'title' => 'Baby Safety', 'desc' => 'Gentle, pure and hypoallergenic care.'],
                    ['icon' => 'science', 'title' => 'Innovation', 'desc' => 'Pioneering sustainable solutions.'],
                    ['icon' => 'money', 'title' => 'Affordability', 'desc' => 'Quality care for every family.'],
                    ['icon' => 'handshake', 'title' => 'Community', 'desc' => 'Opportunities for farming communities.'],
                ];
            @endphp

            @foreach($values as $value)
            <article class="reveal group bg-green-50 rounded-2xl border border-green-100 p-6 text-center hover:bg-white hover:shadow-lg hover:border-green-200 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-white text-green-700 shadow-sm flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => $value['icon'], 'class' => 'w-6 h-6'])
                </div>
                <h3 class="font-extrabold text-gray-800 mt-4 text-base">{{ $value['title'] }}</h3>
                <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $value['desc'] }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- {{-- ============================================================
     8. FAQ — accordion (mirrors the FAQPage structured data)
============================================================= --}}
<section id="faq" class="py-20 md:py-28 bg-[#faf8f3]" aria-labelledby="faq-title">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center reveal">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white border border-green-200 text-green-800 text-xs font-extrabold uppercase tracking-widest rounded-full">
                <span class="text-green-700">@include('storefront.partials.icons', ['icon' => 'chat', 'class' => 'w-4 h-4'])</span>
                Good to Know
            </span>
            <h2 id="faq-title" class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-5">Frequently asked questions</h2>
            <p class="text-gray-600 text-lg mt-3 leading-relaxed">The questions parents, farmers and partners ask us most.</p>
        </div>

        <div class="mt-10 space-y-2">
            @foreach($faqs as $index => $faq)
            <details class="faq-item reveal bg-white border border-green-100 rounded-2xl shadow-sm open:shadow-md open:border-green-200 transition">
                <summary class="flex items-start gap-3 px-4 sm:px-5 py-3.5 cursor-pointer">
                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-700 font-extrabold text-xs shrink-0">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="flex-1 text-base font-extrabold text-gray-900 leading-snug pt-0.5">{{ $faq['q'] }}</h3>
                    <svg class="faq-chevron w-4 h-4 text-green-700 shrink-0 mt-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </summary>
                <div class="pl-4 pr-4 sm:pl-[3.75rem] sm:pr-5 pb-4 text-gray-600 leading-relaxed">{{ $faq['a'] }}</div>
            </details>
            @endforeach
        </div>

        <p class="text-center text-sm text-gray-500 mt-6 reveal">
            Still curious?
            <a href="{{ route('store.contact') }}" class="text-green-700 font-bold hover:underline">Talk to our team</a>
            or browse the
            <a href="{{ route('store.shop') }}" class="text-green-700 font-bold hover:underline">shop</a>.
        </p>
    </div>
</section> -->

{{-- ============================================================
     9. CTA — join the movement
============================================================= --}}
<section id="cta" class="relative overflow-hidden py-12 md:py-16 bg-gradient-to-br from-green-700 to-emerald-900 text-white">
    <div class="absolute -top-24 -right-24 w-72 h-72 bg-green-400/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-emerald-300/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="reveal relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 border border-white/20 text-green-200 text-xs font-extrabold uppercase tracking-widest rounded-full mb-4">
            <span class="text-green-300">@include('storefront.partials.icons', ['icon' => 'heart', 'class' => 'w-4 h-4'])</span>
            Be Part of the Change
        </span>
        <h2 class="text-3xl md:text-4xl font-extrabold">Comfort for your baby. A future for the planet.</h2>
        <p class="text-green-100 text-lg mt-3 max-w-xl mx-auto">Every diaper you choose keeps waste out of landfill and supports the farmers who grow our fibre.</p>
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('store.shop') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-green-700 font-extrabold rounded-full shadow-lg hover:bg-green-50 transition text-lg">
                Shop Our Products
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:translate-x-1 transition" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('store.contact') }}" class="inline-flex items-center px-8 py-4 border-2 border-white/40 text-white font-bold rounded-full hover:bg-white/10 transition text-lg">
                Talk to Us
            </a>
        </div>
        <p class="mt-5 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm text-green-100/90">
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-4 text-green-300">@include('storefront.partials.icons', ['icon' => 'truck', 'class' => 'w-full h-full'])</span>
                Free delivery in Nairobi
            </span>
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-4 text-green-300">@include('storefront.partials.icons', ['icon' => 'pin', 'class' => 'w-full h-full'])</span>
                Nairobi, Kenya &middot; Serving East Africa
            </span>
        </p>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Mobile menu toggle (same pattern as the other storefront pages)
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });

    (function () {
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var canObserve = 'IntersectionObserver' in window;

        // Scroll reveal — progressive enhancement (content stays visible without JS)
        var revealTargets = document.querySelectorAll('.reveal');
        if (reduceMotion || ! canObserve) {
            revealTargets.forEach(function (el) { el.classList.add('is-visible'); });
        } else {
            var revealObserver = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { rootMargin: '0px 0px -10% 0px', threshold: 0.15 });

            revealTargets.forEach(function (el) { revealObserver.observe(el); });
        }

        // Animated impact counters (server-rendered values are the no-JS fallback)
        if (reduceMotion || ! canObserve) return;

        function formatNumber(value, decimals) {
            return value.toLocaleString('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            });
        }

        function countUp(el) {
            var target = parseFloat(el.dataset.count || '0');
            var decimals = parseInt(el.dataset.decimals || '0', 10);
            if (isNaN(target)) return;

            var duration = 1400;
            var start = performance.now();

            function frame(now) {
                var progress = Math.min((now - start) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = formatNumber(target * eased, decimals);
                if (progress < 1) {
                    requestAnimationFrame(frame);
                } else {
                    el.textContent = formatNumber(target, decimals);
                }
            }

            requestAnimationFrame(frame);
        }

        var counterObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    countUp(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });

        document.querySelectorAll('[data-count]').forEach(function (el) {
            counterObserver.observe(el);
        });
    })();
</script>
@endpush
