@extends('storefront.layouts.app')
@section('title', 'Our Impact')

@section('content')
{{-- Hero --}}
<section class="bg-green-700 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-5xl">🌍</span>
        <h1 class="text-4xl font-extrabold mt-4">Our Impact</h1>
        <p class="text-green-100 mt-3 text-lg">Measurable change for the planet, people, and economy.</p>
    </div>
</section>

{{-- Live Counters --}}
@if($impact)
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="text-center p-10 rounded-3xl bg-green-50 border border-green-200">
                <span class="text-6xl">🩲</span>
                <p class="text-5xl font-extrabold text-green-700 mt-4" data-count="{{ $impact->diapers_saved }}">{{ number_format($impact->diapers_saved) }}</p>
                <p class="text-green-700 font-bold mt-2">Diapers Saved from Landfills</p>
            </div>
            <div class="text-center p-10 rounded-3xl bg-blue-50 border border-blue-200">
                <span class="text-6xl">💨</span>
                <p class="text-5xl font-extrabold text-blue-700 mt-4">{{ number_format($impact->co2_reduced, 1) }} kg</p>
                <p class="text-blue-700 font-bold mt-2">CO₂ Emissions Reduced</p>
            </div>
            <div class="text-center p-10 rounded-3xl bg-amber-50 border border-amber-200">
                <span class="text-6xl">👨‍🌾</span>
                <p class="text-5xl font-extrabold text-amber-700 mt-4">{{ number_format($impact->farmers_supported) }}</p>
                <p class="text-amber-700 font-bold mt-2">Farmers Supported</p>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Three Pillars --}}
<section class="py-16 bg-green-50/50">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-green-800 mb-10">Our Three Pillars of Impact</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-3xl p-8 shadow">
                <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-100 text-green-700 text-3xl">🌿</span>
                <h3 class="text-xl font-extrabold text-green-800 mt-4">Environmental</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    <li>✓ Reduced plastic waste in landfills</li>
                    <li>✓ Significant CO₂ savings</li>
                    <li>✓ Fully biodegradable materials</li>
                    <li>✓ Water-efficient manufacturing</li>
                </ul>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow">
                <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 text-blue-700 text-3xl">🤝</span>
                <h3 class="text-xl font-extrabold text-blue-800 mt-4">Social</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    <li>✓ Farmer empowerment programs</li>
                    <li>✓ Creation of green jobs</li>
                    <li>✓ Fair wages & ethical sourcing</li>
                    <li>✓ Supporting rural communities</li>
                </ul>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow">
                <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-amber-100 text-amber-700 text-3xl">💰</span>
                <h3 class="text-xl font-extrabold text-amber-800 mt-4">Economic</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    <li>✓ Affordable eco-diapers for all</li>
                    <li>✓ Cost-saving subscription plans</li>
                    <li>✓ Strengthening the local economy</li>
                    <li>✓ Accessible to East African families</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- Visual infographic / chart --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-green-800 mb-10">Impact Over Time</h2>
        <div class="bg-green-50 rounded-3xl p-8 border border-green-100">
            <canvas id="impactChart" height="120"></canvas>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-green-700 text-white py-14">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-extrabold">Your Purchase = Real Impact</h2>
        <p class="text-green-100 mt-2">Track your personal contribution with every order.</p>
        <a href="{{ route('store.shop') }}" class="inline-block mt-6 px-8 py-3 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 transition">Shop & Make an Impact</a>
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
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22,163,74,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#16a34a'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { font: { family: 'Nunito', weight: 'bold' } } } },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString() } }
                }
            }
        });
    }
</script>
@endpush
