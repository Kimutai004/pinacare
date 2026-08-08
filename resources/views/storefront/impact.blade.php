@extends('storefront.layouts.app')
@section('title', 'Our Impact')

@section('content')
{{-- ===== 1. HERO — Split layout with globe visual ===== --}}
<section class="relative overflow-hidden bg-[#0b3d2e] text-white">
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-green-400/15 blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-4 py-16 md:py-24">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-green-200 text-xs font-bold tracking-widest uppercase rounded-full mb-6">
                    <span class="text-green-300">@include('storefront.partials.icons', ['icon' => 'globe', 'class' => 'w-4 h-4'])</span>
                    Measurable Impact
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">Making a <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-emerald-200">Real Difference</span></h1>
                <p class="text-green-100 mt-4 text-lg leading-relaxed">Every purchase creates measurable change for the planet, people, and economy. Here's the impact we're building together.</p>
                <div class="mt-8 grid grid-cols-2 gap-4 max-w-md">
                    <div class="border-l-2 border-green-400 pl-3">
                        <p class="text-2xl font-extrabold">East Africa</p>
                        <p class="text-xs text-green-100/80 mt-1">Serving the region</p>
                    </div>
                    <div class="border-l-2 border-green-400 pl-3">
                        <p class="text-2xl font-extrabold">100% Bio</p>
                        <p class="text-xs text-green-100/80 mt-1">Compostable materials</p>
                    </div>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <div class="relative mx-auto w-80 h-80">
                    <div class="absolute inset-0 rounded-full bg-green-400/20 blur-2xl"></div>
                    <div class="absolute inset-6 rounded-full border-2 border-dashed border-green-300/40 animate-spin-slow"></div>
                    <div class="absolute inset-0 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                        <span class="w-36 h-36 text-green-300 float">@include('storefront.partials.icons', ['icon' => 'globe', 'class' => 'w-full h-full'])</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none text-[#faf8f3]">
        <svg viewBox="0 0 1440 60" fill="currentColor" preserveAspectRatio="none" class="w-full h-10 md:h-14">
            <path d="M0,32L48,29.3C96,27,192,21,288,24C384,27,480,37,576,37.3C672,37,768,27,864,26.7C960,27,1056,37,1152,34.7C1248,32,1344,21,1392,16L1440,11L1440,60L0,60Z"></path>
        </svg>
    </div>
</section>

{{-- ===== 2. LIVE COUNTERS — Clean stat tiles ===== --}}
@if($impact)
<section class="py-20 md:py-24 bg-[#faf8f3]">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white border border-green-100 rounded-2xl p-8 text-center shadow-sm hover:shadow-md transition">
                <p class="text-xs font-extrabold tracking-widest uppercase text-green-600 mb-4">Diapers Saved</p>
                <p class="text-5xl font-extrabold text-green-800 leading-none tabular-nums" data-count="{{ $impact->diapers_saved }}">{{ number_format($impact->diapers_saved) }}</p>
                <hr class="my-5 border-t border-green-100">
                <p class="text-sm font-semibold text-gray-500">Kept out of landfills to date</p>
            </div>
            <div class="bg-white border border-green-100 rounded-2xl p-8 text-center shadow-sm hover:shadow-md transition">
                <p class="text-xs font-extrabold tracking-widest uppercase text-green-600 mb-4">CO₂ Reduced</p>
                <p class="text-5xl font-extrabold text-green-800 leading-none tabular-nums">{{ number_format($impact->co2_reduced, 1) }} <span class="text-2xl">kg</span></p>
                <hr class="my-5 border-t border-green-100">
                <p class="text-sm font-semibold text-gray-500">Emissions avoided</p>
            </div>
            <div class="bg-white border border-green-100 rounded-2xl p-8 text-center shadow-sm hover:shadow-md transition">
                <p class="text-xs font-extrabold tracking-widest uppercase text-green-600 mb-4">Farmers Supported</p>
                <p class="text-5xl font-extrabold text-green-800 leading-none tabular-nums">{{ number_format($impact->farmers_supported) }}</p>
                <hr class="my-5 border-t border-green-100">
                <p class="text-sm font-semibold text-gray-500">Empowered across East Africa</p>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== 3. THREE PILLARS — Clean cards ===== --}}
<section class="py-20 md:py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full mb-5">Our Pillars</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Three Pillars of Impact</h2>
            <p class="text-gray-600 mt-3 text-lg">How we create value across environmental, social, and economic lines.</p>
        </div>

        @php
            $pillars = [
                ['num' => '01', 'title' => 'Environmental', 'items' => ['Reduced plastic waste in landfills','Significant CO₂ savings','Fully biodegradable materials','Water-efficient manufacturing']],
                ['num' => '02', 'title' => 'Social', 'items' => ['Farmer empowerment programs','Creation of green jobs','Fair wages & ethical sourcing','Supporting rural communities']],
                ['num' => '03', 'title' => 'Economic', 'items' => ['Affordable eco-diapers for all','Cost-saving subscription plans','Strengthening the local economy','Accessible to East African families']],
            ];
        @endphp

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($pillars as $pillar)
            <div class="bg-white border border-green-500 rounded-2xl p-8 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-4xl font-extrabold text-green-600">{{ $pillar['num'] }}</span>
                    <span class="w-10 h-1 rounded-full bg-green-600"></span>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900">{{ $pillar['title'] }}</h3>
                <p class="text-sm text-gray-400 font-semibold uppercase tracking-widest mt-1">Impact</p>
                <ul class="mt-6 space-y-3">
                    @foreach($pillar['items'] as $item)
                    <li class="flex items-start gap-3 text-sm text-gray-700">
                        <span class="mt-0.5 w-4 h-4 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-2.5 h-2.5 text-green-700"><path d="M5 13l4 4L19 7"/></svg>
                        </span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 4. IMPACT OVER TIME — Chart ===== --}}
<section class="py-20 md:py-24 bg-green-50/50">
    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-green-100 p-8 md:p-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Impact Over Time</h2>
                <p class="text-gray-600 mt-2">Tracking diapers saved as our community grows.</p>
            </div>
            <canvas id="impactChart" height="140"></canvas>
        </div>
    </div>
</section>

{{-- ===== 5. CTA ===== --}}
<section class="py-16 md:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full mb-5">Get Involved</span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Your Purchase = Real Impact</h2>
        <p class="text-gray-600 mt-4 text-lg">Track your personal contribution with every order.</p>
        <a href="{{ route('store.shop') }}" class="group inline-flex items-center gap-2 mt-8 px-10 py-4 bg-green-700 text-white font-extrabold rounded-full hover:bg-green-800 transition shadow-lg">
            Shop & Make an Impact
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:translate-x-1 transition"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });

    const labels = @json($metrics->reverse()->map(fn($m) => $m->created_at->format('M Y'))->values());
    const diapers = @json($metrics->reverse()->pluck('diapers_saved')->values());

    if (document.getElementById('impactChart') && labels.length) {
        new Chart(document.getElementById('impactChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Diapers Saved',
                    data: diapers,
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13,148,136,0.12)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#0d9488',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { font: { family: 'Nunito', weight: 'bold' } } } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f0fdf4' }, ticks: { callback: v => v.toLocaleString() } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
</script>
@endpush
