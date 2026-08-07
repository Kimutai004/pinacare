@extends('storefront.layouts.app')
@section('title', 'Contact Us')

@section('content')
{{-- Hero --}}
<section class="bg-green-700 text-white py-14">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-5xl">💬</span>
        <h1 class="text-4xl font-extrabold mt-4">Contact Us</h1>
        <p class="text-green-100 mt-3">We'd love to hear from you! Questions, feedback, or partnership inquiries.</p>
    </div>
</section>

{{-- Contact info --}}
<section class="py-14 bg-white">
    <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-6">
        <div class="text-center p-6 rounded-2xl bg-green-50 border border-green-100">
            <span class="text-3xl">📧</span>
            <h3 class="font-bold text-gray-800 mt-3">Email</h3>
            <a href="mailto:pinacare26@gmail.com" class="text-green-700 font-bold hover:underline">pinacare26@gmail.com</a>
        </div>
        <div class="text-center p-6 rounded-2xl bg-blue-50 border border-blue-100">
            <span class="text-3xl">📞</span>
            <h3 class="font-bold text-gray-800 mt-3">Phone / WhatsApp</h3>
            <a href="tel:+254712345678" class="text-blue-700 font-bold hover:underline">+254 712 345 678</a>
        </div>
        <div class="text-center p-6 rounded-2xl bg-amber-50 border border-amber-100">
            <span class="text-3xl">📍</span>
            <h3 class="font-bold text-gray-800 mt-3">Location</h3>
            <p class="text-gray-600 text-sm">Nairobi, Kenya<br>Serving East Africa</p>
        </div>
    </div>
</section>

{{-- Contact form + FAQ --}}
<section class="py-14 bg-green-50/50">
    <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-2 gap-10">
        <div class="bg-white rounded-3xl p-8 shadow border border-green-50">
            <h2 class="text-2xl font-extrabold text-green-800 mb-6">Send Us a Message</h2>
            <form method="POST" action="{{ route('store.newsletter') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Your Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Your Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Message</label>
                    <textarea name="message" rows="4" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>
                <button class="w-full px-6 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition">Send Message</button>
            </form>
        </div>

        {{-- FAQ --}}
        <div id="faq" class="bg-white rounded-3xl p-8 shadow border border-green-50">
            <h2 class="text-2xl font-extrabold text-green-800 mb-6">FAQ</h2>
            <div class="space-y-4">
                <details class="bg-green-50 rounded-xl p-4">
                    <summary class="font-bold text-gray-800 cursor-pointer">🛵 How much is delivery?</summary>
                    <p class="text-sm text-gray-600 mt-2">Delivery is FREE within Nairobi. Other regions in Kenya and East Africa are charged a flat rate based on location.</p>
                </details>
                <details class="bg-green-50 rounded-xl p-4">
                    <summary class="font-bold text-gray-800 cursor-pointer">↩️ What is your return policy?</summary>
                    <p class="text-sm text-gray-600 mt-2">Unopened products can be returned within 7 days of delivery for a full refund. Contact us to start a return.</p>
                </details>
                <details class="bg-green-50 rounded-xl p-4">
                    <summary class="font-bold text-gray-800 cursor-pointer">🌱 Are your diapers truly biodegradable?</summary>
                    <p class="text-sm text-gray-600 mt-2">Yes! Our diapers are made from plant-based, compostable materials and break down naturally — no harmful chemicals.</p>
                </details>
                <details class="bg-green-50 rounded-xl p-4">
                    <summary class="font-bold text-gray-800 cursor-pointer">📦 How does subscription work?</summary>
                    <p class="text-sm text-gray-600 mt-2">Choose "Subscribe & Save" at checkout for monthly auto-deliveries at a 15% discount. Pause or cancel anytime.</p>
                </details>
                <details class="bg-green-50 rounded-xl p-4">
                    <summary class="font-bold text-gray-800 cursor-pointer">🤝 Do you partner with hospitals?</summary>
                    <p class="text-sm text-gray-600 mt-2">Yes! We collaborate with pediatricians, maternal clinics, and hospitals. Reach out to explore partnerships.</p>
                </details>
            </div>
        </div>
    </div>
</section>

{{-- Social CTA --}}
<section class="py-14 bg-white">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-extrabold text-green-800 mb-6">Follow Us</h2>
        <div class="flex justify-center gap-4">
            <a href="#" class="w-12 h-12 rounded-full bg-green-600 text-white flex items-center justify-center hover:bg-green-700 transition text-xl">f</a>
            <a href="#" class="w-12 h-12 rounded-full bg-green-600 text-white flex items-center justify-center hover:bg-green-700 transition text-xl">𝕏</a>
            <a href="#" class="w-12 h-12 rounded-full bg-green-600 text-white flex items-center justify-center hover:bg-green-700 transition text-xl">📸</a>
            <a href="#" class="w-12 h-12 rounded-full bg-green-600 text-white flex items-center justify-center hover:bg-green-700 transition text-xl">💬</a>
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
