@extends('storefront.layouts.app')
@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with PINACARE — questions about orders, partnerships or our eco-friendly diapers? Reach our team in Nairobi, Kenya.')

@section('content')
{{-- ===== 1. HERO ===== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-800 text-white">
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-green-400/15 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-emerald-300/15 blur-3xl"></div>
    <div class="relative max-w-4xl mx-auto px-4 text-center py-16 md:py-20">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-green-200 text-xs font-bold tracking-widest uppercase rounded-full mb-6">
            <span class="text-green-300">@include('storefront.partials.icons', ['icon' => 'chat', 'class' => 'w-4 h-4'])</span>
            We'd Love to Hear From You
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">Contact Us</h1>
        <p class="text-green-100 mt-4 text-lg max-w-2xl mx-auto">Questions, feedback, or partnership inquiries — our team is here to help.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none text-[#faf8f3]">
        <svg viewBox="0 0 1440 60" fill="currentColor" preserveAspectRatio="none" class="w-full h-10 md:h-14">
            <path d="M0,32L48,29.3C96,27,192,21,288,24C384,27,480,37,576,37.3C672,37,768,27,864,26.7C960,27,1056,37,1152,34.7C1248,32,1344,21,1392,16L1440,11L1440,60L0,60Z"></path>
        </svg>
    </div>
</section>

{{-- ===== 2. CONTACT INFO CARDS ===== --}}
<section class="py-16 bg-[#faf8f3]">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="group relative overflow-hidden bg-white rounded-3xl p-8 text-center shadow-sm border border-green-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-green-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white flex items-center justify-center mx-auto shadow-lg">
                        @include('storefront.partials.icons', ['icon' => 'email', 'class' => 'w-7 h-7'])
                    </div>
                    <h3 class="font-extrabold text-gray-800 mt-4">Email</h3>
                    <a href="mailto:info@pinacare.com" class="text-green-700 font-bold hover:underline mt-1 block">info@pinacare.com</a>
                </div>
            </div>
            <div class="group relative overflow-hidden bg-white rounded-3xl p-8 text-center shadow-sm border border-blue-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-blue-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 text-white flex items-center justify-center mx-auto shadow-lg">
                        @include('storefront.partials.icons', ['icon' => 'phone', 'class' => 'w-7 h-7'])
                    </div>
                    <h3 class="font-extrabold text-gray-800 mt-4">Phone / WhatsApp</h3>
                    <a href="tel:0751340591" class="text-blue-700 font-bold hover:underline mt-1 block">0751340591 / 0106365682</a>
                </div>
            </div>
            <div class="group relative overflow-hidden bg-white rounded-3xl p-8 text-center shadow-sm border border-amber-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-amber-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center mx-auto shadow-lg">
                        @include('storefront.partials.icons', ['icon' => 'pin', 'class' => 'w-7 h-7'])
                    </div>
                    <h3 class="font-extrabold text-gray-800 mt-4">Location</h3>
                    <p class="text-gray-600 text-sm mt-1">Nairobi, Kenya<br>Serving East Africa</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 3. FORM + FAQ ===== --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-2 gap-10">
        {{-- Form --}}
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 border border-green-100">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-11 h-11 rounded-xl bg-green-700 text-white flex items-center justify-center">@include('storefront.partials.icons', ['icon' => 'chat', 'class' => 'w-5 h-5'])</span>
                <h2 class="text-2xl font-extrabold text-green-800">Send Us a Message</h2>
            </div>
            <form method="POST" action="{{ route('store.newsletter') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Your Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Your Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Subject</label>
                    <input type="text" name="subject" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Message</label>
                    <textarea name="message" rows="4" required class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                </div>
                <button class="w-full px-6 py-3.5 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow flex items-center justify-center gap-2">
                    @include('storefront.partials.icons', ['icon' => 'email', 'class' => 'w-4 h-4'])
                    Send Message
                </button>
            </form>
        </div>

        {{-- FAQ --}}
        <div id="faq">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-11 h-11 rounded-xl bg-blue-700 text-white flex items-center justify-center">@include('storefront.partials.icons', ['icon' => 'chat', 'class' => 'w-5 h-5'])</span>
                <h2 class="text-2xl font-extrabold text-blue-800">FAQ</h2>
            </div>
            <div class="space-y-4">
                <details class="bg-white rounded-2xl p-5 border border-green-50 shadow-sm group" open>
                    <summary class="font-bold text-gray-800 cursor-pointer flex items-center justify-between">
                        How much is delivery?
                        <span class="text-green-600 group-open:rotate-45 transition-transform">@include('storefront.partials.icons', ['icon' => 'arrow_right', 'class' => 'w-4 h-4'])</span>
                    </summary>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">Delivery is FREE within Nairobi. Other regions in Kenya and East Africa are charged a flat rate based on location.</p>
                </details>
                <details class="bg-white rounded-2xl p-5 border border-green-50 shadow-sm group">
                    <summary class="font-bold text-gray-800 cursor-pointer flex items-center justify-between">
                        What is your return policy?
                        <span class="text-green-600 group-open:rotate-45 transition-transform">@include('storefront.partials.icons', ['icon' => 'arrow_right', 'class' => 'w-4 h-4'])</span>
                    </summary>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">Unopened products can be returned within 7 days of delivery for a full refund. Contact us to start a return.</p>
                </details>
                <details class="bg-white rounded-2xl p-5 border border-green-50 shadow-sm group">
                    <summary class="font-bold text-gray-800 cursor-pointer flex items-center justify-between">
                        Are your diapers truly biodegradable?
                        <span class="text-green-600 group-open:rotate-45 transition-transform">@include('storefront.partials.icons', ['icon' => 'arrow_right', 'class' => 'w-4 h-4'])</span>
                    </summary>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">Yes! Our diapers are made from plant-based, compostable materials and break down naturally — no harmful chemicals.</p>
                </details>
                <details class="bg-white rounded-2xl p-5 border border-green-50 shadow-sm group">
                    <summary class="font-bold text-gray-800 cursor-pointer flex items-center justify-between">
                        How does subscription work?
                        <span class="text-green-600 group-open:rotate-45 transition-transform">@include('storefront.partials.icons', ['icon' => 'arrow_right', 'class' => 'w-4 h-4'])</span>
                    </summary>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">Choose "Subscribe & Save" at checkout for monthly auto-deliveries at a 15% discount. Pause or cancel anytime.</p>
                </details>
                <details class="bg-white rounded-2xl p-5 border border-green-50 shadow-sm group">
                    <summary class="font-bold text-gray-800 cursor-pointer flex items-center justify-between">
                        Do you partner with hospitals?
                        <span class="text-green-600 group-open:rotate-45 transition-transform">@include('storefront.partials.icons', ['icon' => 'arrow_right', 'class' => 'w-4 h-4'])</span>
                    </summary>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">Yes! We collaborate with pediatricians, maternal clinics, and hospitals. Reach out to explore partnerships.</p>
                </details>
            </div>
        </div>
    </div>
</section>

{{-- ===== 4. FOLLOW US ===== --}}
<section class="py-16 bg-[#faf8f3]">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full mb-5">Stay Connected</span>
        <h2 class="text-3xl font-extrabold text-gray-900">Follow Us</h2>
        <p class="text-gray-600 mt-2">Join our growing community of eco-conscious parents.</p>
        <div class="flex justify-center gap-4 mt-8">
            @foreach(['facebook','x','instagram','whatsapp'] as $social)
            <a href="#" class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-600 to-emerald-700 text-white flex items-center justify-center hover:scale-110 hover:shadow-xl transition-all duration-300" aria-label="{{ ucfirst($social) }}">
                @include('storefront.partials.icons', ['icon' => $social, 'class' => 'w-7 h-7'])
            </a>
            @endforeach
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
