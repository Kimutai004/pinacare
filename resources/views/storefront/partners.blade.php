@extends('storefront.layouts.app')
@section('title', 'Healthcare Partnerships')

@section('content')
{{-- Hero --}}
<section class="bg-blue-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-5xl">🏥</span>
        <h1 class="text-4xl font-extrabold mt-4">Trusted by Healthcare Professionals</h1>
        <p class="text-blue-100 mt-3 text-lg">Endorsed by pediatricians, hospitals, and maternal clinics across East Africa.</p>
    </div>
</section>

{{-- Trust badges --}}
<section class="py-14 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-6 rounded-2xl bg-green-50 border border-green-100">
                <span class="text-4xl">🩺</span>
                <h3 class="font-bold text-gray-800 mt-3">Pediatrician Tested</h3>
            </div>
            <div class="text-center p-6 rounded-2xl bg-blue-50 border border-blue-100">
                <span class="text-4xl">🧪</span>
                <h3 class="font-bold text-gray-800 mt-3">Dermatologist Approved</h3>
            </div>
            <div class="text-center p-6 rounded-2xl bg-amber-50 border border-amber-100">
                <span class="text-4xl">🌸</span>
                <h3 class="font-bold text-gray-800 mt-3">Hypoallergenic</h3>
            </div>
            <div class="text-center p-6 rounded-2xl bg-emerald-50 border border-emerald-100">
                <span class="text-4xl">🌿</span>
                <h3 class="font-bold text-gray-800 mt-3">Chemical-Free</h3>
            </div>
        </div>
    </div>
</section>

{{-- Endorsements --}}
<section class="py-16 bg-green-50/50">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-green-800 mb-10">Partner Endorsements</h2>
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-8 shadow flex flex-col md:flex-row gap-6 items-start">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-3xl flex-shrink-0">👩‍⚕️</div>
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Dr. A. Njeri — Pediatrician</h3>
                    <p class="text-sm text-gray-600 mt-2">"I recommend PINACARE diapers to my patients because they're gentle on delicate skin and free from harmful chemicals. It's wonderful to see a product that cares for both babies and the environment."</p>
                </div>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow flex flex-col md:flex-row gap-6 items-start">
                <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-3xl flex-shrink-0">🏥</div>
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">MamaCare Maternal Clinic</h3>
                    <p class="text-sm text-gray-600 mt-2">"PINACARE aligns perfectly with our mission of promoting health and sustainability. We partner with them to provide eco-friendly baby care education to new mothers."</p>
                </div>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow flex flex-col md:flex-row gap-6 items-start">
                <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center text-3xl flex-shrink-0">🧑‍⚕️</div>
                <div>
                    <h3 class="font-extrabold text-gray-800 text-lg">Dr. K. Otieno — Dermatologist</h3>
                    <p class="text-sm text-gray-600 mt-2">"The hypoallergenic, breathable materials in PINACARE products significantly reduce the risk of diaper rash. A thoughtful, science-backed product."</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-blue-600 text-white py-14">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-extrabold">Healthcare Partners Welcome</h2>
        <p class="text-blue-100 mt-2">Interested in a partnership? We'd love to collaborate.</p>
        <a href="{{ route('store.contact') }}" class="inline-block mt-6 px-8 py-3 bg-white text-blue-700 font-bold rounded-full hover:bg-blue-50 transition">Contact Us</a>
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
