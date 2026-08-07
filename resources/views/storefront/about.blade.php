@extends('storefront.layouts.app')
@section('title', 'About Us')

@section('content')
{{-- Hero --}}
<section class="bg-green-700 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-5xl">🌱</span>
        <h1 class="text-4xl font-extrabold mt-4">Our Story</h1>
        <p class="text-green-100 mt-3 text-lg max-w-2xl mx-auto">From pineapple leaf to baby comfort — we're building a circular economy that nurtures babies and protects the planet.</p>
    </div>
</section>

{{-- Vision & Mission --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-8">
        <div class="bg-green-50 rounded-3xl p-8 border border-green-100">
            <span class="text-4xl">🔭</span>
            <h2 class="text-2xl font-extrabold text-green-800 mt-3">Our Vision</h2>
            <p class="text-gray-600 mt-3 leading-relaxed">A world where every baby grows up healthy, every farmer thrives, and every diaper we use gives back to the earth instead of taking from it.</p>
        </div>
        <div class="bg-blue-50 rounded-3xl p-8 border border-blue-100">
            <span class="text-4xl">🎯</span>
            <h2 class="text-2xl font-extrabold text-blue-800 mt-3">Our Mission</h2>
            <p class="text-gray-600 mt-3 leading-relaxed">To create affordable, sustainable baby care products that create green jobs, empower farming communities, and reduce waste — all while keeping babies safe and comfortable.</p>
        </div>
    </div>
</section>

{{-- Storytelling: From pineapple leaf to baby comfort --}}
<section class="py-16 bg-green-50/50">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-green-800 mb-12">From Pineapple Leaf to Baby Comfort</h2>
        <div class="grid md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto text-4xl">🍍</div>
                <h3 class="font-bold text-gray-800 mt-4">1. Harvest</h3>
                <p class="text-sm text-gray-600 mt-2">Farmers collect pineapple leaves after harvest — turning agricultural waste into a valuable resource.</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto text-4xl">🧵</div>
                <h3 class="font-bold text-gray-800 mt-4">2. Extract Fibers</h3>
                <p class="text-sm text-gray-600 mt-2">Strong, soft natural fibers are extracted and processed without harmful chemicals.</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto text-4xl">🩲</div>
                <h3 class="font-bold text-gray-800 mt-4">3. Craft Diapers</h3>
                <p class="text-sm text-gray-600 mt-2">Fibers are woven into ultra-soft, absorbent, biodegradable baby diapers.</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto text-4xl">♻️</div>
                <h3 class="font-bold text-gray-800 mt-4">4. Compost & Renew</h3>
                <p class="text-sm text-gray-600 mt-2">Used diapers break down naturally, completing the circular economy loop.</p>
            </div>
        </div>
    </div>
</section>

{{-- SDG Contribution --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-green-800 mb-2">Our Contribution to the SDGs</h2>
        <p class="text-center text-gray-600 mb-10">Aligned with the United Nations Sustainable Development Goals</p>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center p-8 rounded-2xl border-2 border-red-200 bg-red-50">
                <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-red-500 text-white font-extrabold text-xl">3</span>
                <h3 class="font-bold text-gray-800 mt-4">Good Health & Well-Being</h3>
                <p class="text-sm text-gray-600 mt-2">Dermatologist-tested, hypoallergenic products keep babies healthy and rash-free.</p>
            </div>
            <div class="text-center p-8 rounded-2xl border-2 border-green-200 bg-green-50">
                <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-500 text-white font-extrabold text-xl">12</span>
                <h3 class="font-bold text-gray-800 mt-4">Responsible Consumption</h3>
                <p class="text-sm text-gray-600 mt-2">Biodegradable materials reduce landfill waste and promote circular consumption.</p>
            </div>
            <div class="text-center p-8 rounded-2xl border-2 border-emerald-200 bg-emerald-50">
                <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-emerald-500 text-white font-extrabold text-xl">13</span>
                <h3 class="font-bold text-gray-800 mt-4">Climate Action</h3>
                <p class="text-sm text-gray-600 mt-2">Reduced carbon emissions through sustainable sourcing and local production.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-green-700 text-white py-14">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-extrabold">Be Part of the Change</h2>
        <p class="text-green-100 mt-2">Every diaper you choose makes a difference.</p>
        <a href="{{ route('store.shop') }}" class="inline-block mt-6 px-8 py-3 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 transition">Shop Our Products</a>
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
