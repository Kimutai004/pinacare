@extends('storefront.layouts.app')
@section('title', 'Healthcare Partnerships')
@section('meta_description', 'PINACARE partners with healthcare providers to bring safe, sustainable baby care to more families. Learn about our partnerships and how to collaborate.')

@section('content')
{{-- ===== 1. HERO ===== --}}
<section class="relative overflow-hidden bg-[#0b3d2e] text-white">
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-blue-400/15 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-cyan-300/15 blur-3xl"></div>
    <div class="relative max-w-4xl mx-auto px-4 text-center py-16 md:py-20">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-blue-200 text-xs font-bold tracking-widest uppercase rounded-full mb-6">
            <span class="text-blue-300">@include('storefront.partials.icons', ['icon' => 'hospital', 'class' => 'w-4 h-4'])</span>
            Medical Endorsements
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">Trusted by Healthcare Professionals</h1>
        <p class="text-blue-100 mt-4 text-lg">Endorsed by pediatricians, hospitals, and maternal clinics across East Africa.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none text-[#faf8f3]">
        <svg viewBox="0 0 1440 60" fill="currentColor" preserveAspectRatio="none" class="w-full h-10 md:h-14">
            <path d="M0,32L48,29.3C96,27,192,21,288,24C384,27,480,37,576,37.3C672,37,768,27,864,26.7C960,27,1056,37,1152,34.7C1248,32,1344,21,1392,16L1440,11L1440,60L0,60Z"></path>
        </svg>
    </div>
</section>

{{-- ===== 2. TRUST BADGES ===== --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="group bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 text-center border border-green-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => 'stethoscope', 'class' => 'w-8 h-8'])
                </div>
                <h3 class="font-extrabold text-gray-800 mt-4">Pediatrician Tested</h3>
                <p class="text-xs text-gray-500 mt-1">Gentle & safe for delicate skin</p>
            </div>
            <div class="group bg-gradient-to-br from-blue-50 to-cyan-50 rounded-3xl p-8 text-center border border-blue-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 text-white flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => 'flask', 'class' => 'w-8 h-8'])
                </div>
                <h3 class="font-extrabold text-gray-800 mt-4">Dermatologist Approved</h3>
                <p class="text-xs text-gray-500 mt-1">Reduces risk of diaper rash</p>
            </div>
            <div class="group bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-8 text-center border border-amber-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => 'flower', 'class' => 'w-8 h-8'])
                </div>
                <h3 class="font-extrabold text-gray-800 mt-4">Hypoallergenic</h3>
                <p class="text-xs text-gray-500 mt-1">Free from irritants & fragrances</p>
            </div>
            <div class="group bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl p-8 text-center border border-emerald-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-8 h-8'])
                </div>
                <h3 class="font-extrabold text-gray-800 mt-4">Chemical-Free</h3>
                <p class="text-xs text-gray-500 mt-1">Plant-based & compostable</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== 4. PARTNERSHIP CTA ===== --}}
<section class="relative overflow-hidden py-16 bg-gradient-to-br from-green-700 to-green-800 text-white">
    <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full bg-white/5"></div>
    <div class="absolute -bottom-10 -left-10 w-64 h-64 rounded-full bg-white/5"></div>
    <div class="relative max-w-3xl mx-auto px-4 text-center">
        <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur border border-white/20 flex items-center justify-center mx-auto mb-5">
            <span class="w-8 h-8">@include('storefront.partials.icons', ['icon' => 'handshake', 'class' => 'w-full h-full'])</span>
        </div>
        <h2 class="text-3xl md:text-4xl font-extrabold">Healthcare Partners Welcome</h2>
        <p class="text-blue-100 mt-3 text-lg">Interested in a partnership? We'd love to collaborate and grow together.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center mt-8">
            <a href="{{ route('store.contact') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white text-blue-700 font-bold rounded-full hover:bg-blue-50 transition shadow-lg">
                Contact Us
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('store.shop') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 border-2 border-white/60 text-white font-bold rounded-full hover:bg-white/10 transition">
                @include('storefront.partials.icons', ['icon' => 'box', 'class' => 'w-4 h-4'])
                Explore Products
            </a>
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
</content>
