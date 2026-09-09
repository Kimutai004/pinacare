@extends('storefront.layouts.app')
@section('title', 'Checkout')
@section('robots', 'noindex, nofollow')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-12">
    {{-- Header / progress --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-green-800">Secure Checkout</h1>
            <p class="text-gray-500 mt-1 flex items-center gap-1.5"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'truck', 'class' => 'w-4 h-4'])</span>Guest checkout — no account needed. Free delivery in Nairobi!</p>
        </div>
        <div class="flex items-center gap-2 mt-4 md:mt-0 text-sm">
            <span class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold">✓</span>
            <span class="text-green-700 font-bold">Cart</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-gray-400"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            <span class="w-8 h-8 rounded-full bg-green-700 text-white flex items-center justify-center font-bold">2</span>
            <span class="text-gray-800 font-bold">Checkout</span>
        </div>
    </div>

    <form method="POST" action="{{ route('store.checkout.store') }}" class="grid lg:grid-cols-3 gap-8">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            {{-- 1. Contact & Delivery --}}
            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-green-50">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <span class="w-9 h-9 rounded-full bg-green-700 text-white font-bold flex items-center justify-center text-sm">1</span>
                    <h2 class="font-extrabold text-gray-800 text-lg flex items-center gap-2"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'user', 'class' => 'w-5 h-5'])</span>Contact & Delivery</h2>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+254..." required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Delivery Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, City, Kenya" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            {{-- 2. Payment method --}}
            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-green-50">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <span class="w-9 h-9 rounded-full bg-green-700 text-white font-bold flex items-center justify-center text-sm">2</span>
                    <h2 class="font-extrabold text-gray-800 text-lg flex items-center gap-2"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'card', 'class' => 'w-5 h-5'])</span>Payment Method</h2>
                </div>
                <div class="grid sm:grid-cols-3 gap-3">
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer has-[:checked]:border-green-600 has-[:checked]:bg-green-50 hover:border-green-300 transition">
                        <input type="radio" name="payment_method" value="mpesa" class="accent-green-600" checked>
                        <span class="w-9 h-9 text-green-600 flex-shrink-0">@include('storefront.partials.icons', ['icon' => 'mpesa', 'class' => 'w-full h-full'])</span>
                        <div><p class="font-bold text-sm text-gray-800">M-Pesa</p><p class="text-xs text-gray-500">Lipa na M-Pesa</p></div>
                    </label>
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer has-[:checked]:border-green-600 has-[:checked]:bg-green-50 hover:border-green-300 transition">
                        <input type="radio" name="payment_method" value="card" class="accent-green-600">
                        <span class="w-9 h-9 text-blue-600 flex-shrink-0">@include('storefront.partials.icons', ['icon' => 'card', 'class' => 'w-full h-full'])</span>
                        <div><p class="font-bold text-sm text-gray-800">Card</p><p class="text-xs text-gray-500">Visa / Mastercard</p></div>
                    </label>
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer has-[:checked]:border-green-600 has-[:checked]:bg-green-50 hover:border-green-300 transition">
                        <input type="radio" name="payment_method" value="paypal" class="accent-green-600">
                        <span class="w-9 h-9 text-blue-700 flex-shrink-0">@include('storefront.partials.icons', ['icon' => 'paypal', 'class' => 'w-full h-full'])</span>
                        <div><p class="font-bold text-sm text-gray-800">PayPal</p><p class="text-xs text-gray-500">International</p></div>
                    </label>
                </div>
            </div>

            {{-- 3. Subscription option --}}
            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-green-50">
                <label class="cursor-pointer block">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-9 h-9 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center text-sm">3</span>
                        <h2 class="font-extrabold text-gray-800 text-lg flex items-center gap-2"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'box', 'class' => 'w-5 h-5'])</span>Subscription Option</h2>
                    </div>
                    <div class="flex items-start gap-3 p-4 border-2 border-green-200 bg-green-50 rounded-xl">
                        <input type="checkbox" name="subscribe" value="1" class="mt-1 accent-green-600">
                        <div>
                            <p class="font-bold text-sm text-gray-800">Subscribe & Save 15%</p>
                            <p class="text-xs text-gray-600">Get automatic monthly deliveries of this order at a 15% discount. Pause or cancel anytime.</p>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        {{-- Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-green-50 sticky top-20">
                <h2 class="font-extrabold text-gray-800 text-lg mb-5 flex items-center gap-2">
                    <span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'cart', 'class' => 'w-5 h-5'])</span>
                    Order Summary
                </h2>
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Items</span><span class="font-bold text-gray-800">KES {{ number_format($total) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Delivery</span><span class="text-green-600 font-bold">Free</span>
                </div>
                <div class="border-t border-gray-200 my-4 pt-4 flex justify-between font-extrabold text-gray-800 text-lg">
                    <span>Total</span><span>KES {{ number_format($total) }}</span>
                </div>
                <button type="submit" class="w-full px-6 py-3.5 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow-lg text-lg">
                    Place Order — KES {{ number_format($total) }}
                </button>
                <p class="text-center text-xs text-gray-400 mt-3"><span class="inline-flex items-center gap-1 justify-center"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'lock', 'class' => 'w-3.5 h-3.5'])</span>Your information is secure and encrypted.</span></p>
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-center gap-2 text-xs text-gray-500">
                    <span class="w-5 h-5 text-green-600">@include('storefront.partials.icons', ['icon' => 'mpesa', 'class' => 'w-full h-full'])</span>
                    <span class="w-5 h-5 text-blue-600">@include('storefront.partials.icons', ['icon' => 'card', 'class' => 'w-full h-full'])</span>
                    <span class="w-5 h-5 text-blue-700">@include('storefront.partials.icons', ['icon' => 'paypal', 'class' => 'w-full h-full'])</span>
                    <span class="ml-1">M-Pesa · Card · PayPal</span>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>
@endpush
