@extends('storefront.layouts.app')
@section('title', 'Healthcare Partnerships')

@section('content')
{{-- ===== 1. HERO ===== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-blue-800 via-blue-700 to-cyan-800 text-white">
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

{{-- ===== 3. ENDORSEMENTS ===== --}}
<section class="py-16 bg-[#faf8f3]">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-extrabold tracking-widest uppercase rounded-full mb-4">Testimonials</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Partner Endorsements</h2>
        </div>
        <div class="space-y-6">
            <div class="relative bg-white rounded-3xl p-8 shadow-sm border border-green-50 hover:shadow-xl transition flex flex-col md:flex-row gap-6 items-start overflow-hidden">
                <div class="absolute -top-6 -left-6 w-20 h-20 rounded-full bg-green-50"></div>
                <div class="relative w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 text-white flex items-center justify-center flex-shrink-0 shadow-lg">
                    @include('storefront.partials.icons', ['icon' => 'stethoscope', 'class' => 'w-8 h-8'])
                </div>
                <div class="relative">
                    <h3 class="font-extrabold text-gray-800 text-lg">Dr. A. Njeri — Pediatrician</h3>
                    <div class="flex text-yellow-400 mt-1 mb-3">
                        @for($s=0;$s<5;$s++)<svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">"I recommend PINACARE diapers to my patients because they're gentle on delicate skin and free from harmful chemicals. It's wonderful to see a product that cares for both babies and the environment."</p>
                </div>
            </div>
            <div class="relative bg-white rounded-3xl p-8 shadow-sm border border-green-50 hover:shadow-xl transition flex flex-col md:flex-row gap-6 items-start overflow-hidden">
                <div class="absolute -top-6 -left-6 w-20 h-20 rounded-full bg-green-50"></div>
                <div class="relative w-16 h-16 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-lg">
                    @include('storefront.partials.icons', ['icon' => 'hospital', 'class' => 'w-8 h-8'])
                </div>
                <div class="relative">
                    <h3 class="font-extrabold text-gray-800 text-lg">MamaCare Maternal Clinic</h3>
                    <div class="flex text-yellow-400 mt-1 mb-3">
                        @for($s=0;$s<5;$s++)<svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">"PINACARE aligns perfectly with our mission of promoting health and sustainability. We partner with them to provide eco-friendly baby care education to new mothers."</p>
                </div>
            </div>
            <div class="relative bg-white rounded-3xl p-8 shadow-sm border border-green-50 hover:shadow-xl transition flex flex-col md:flex-row gap-6 items-start overflow-hidden">
                <div class="absolute -top-6 -left-6 w-20 h-20 rounded-full bg-amber-50"></div>
                <div class="relative w-16 h-16 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center flex-shrink-0 shadow-lg">
                    @include('storefront.partials.icons', ['icon' => 'flask', 'class' => 'w-8 h-8'])
                </div>
                <div class="relative">
                    <h3 class="font-extrabold text-gray-800 text-lg">Dr. K. Otieno — Dermatologist</h3>
                    <div class="flex text-yellow-400 mt-1 mb-3">
                        @for($s=0;$s<5;$s++)<svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">"The hypoallergenic, breathable materials in PINACARE products significantly reduce the risk of diaper rash. A thoughtful, science-backed product."</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 4. PARTNERSHIP CTA ===== --}}
<section class="relative overflow-hidden py-16 bg-gradient-to-br from-blue-700 to-cyan-800 text-white">
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
