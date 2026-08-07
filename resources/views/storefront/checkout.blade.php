@extends('storefront.layouts.app')
@section('title', 'Checkout')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-extrabold text-green-800 mb-2">Checkout</h1>
    <p class="text-gray-500 mb-8">Guest checkout — no account needed. Enjoy free delivery in Nairobi! 🚚</p>

    <form method="POST" action="{{ route('store.checkout.store') }}" class="grid lg:grid-cols-3 gap-8">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            {{-- Contact & Delivery --}}
            <div class="bg-white rounded-2xl p-6 shadow border border-green-50">
                <h2 class="font-extrabold text-gray-800 text-lg mb-4">👤 Contact & Delivery</h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+254..." required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Delivery Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, City, Kenya" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
            </div>

            {{-- Payment method --}}
            <div class="bg-white rounded-2xl p-6 shadow border border-green-50">
                <h2 class="font-extrabold text-gray-800 text-lg mb-4">💳 Payment Method</h2>
                <div class="grid sm:grid-cols-3 gap-3">
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer has-[:checked]:border-green-600 has-[:checked]:bg-green-50 hover:border-green-300 transition">
                        <input type="radio" name="payment_method" value="mpesa" class="accent-green-600" checked>
                        <span class="text-2xl">📱</span>
                        <div><p class="font-bold text-sm text-gray-800">M-Pesa</p><p class="text-xs text-gray-500">Lipa na M-Pesa</p></div>
                    </label>
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-300 transition">
                        <input type="radio" name="payment_method" value="card" class="accent-green-600">
                        <span class="text-2xl">💳</span>
                        <div><p class="font-bold text-sm text-gray-800">Card</p><p class="text-xs text-gray-500">Visa / Mastercard</p></div>
                    </label>
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-300 transition">
                        <input type="radio" name="payment_method" value="paypal" class="accent-green-600">
                        <span class="text-2xl">🅿️</span>
                        <div><p class="font-bold text-sm text-gray-800">PayPal</p><p class="text-xs text-gray-500">International</p></div>
                    </label>
                </div>
            </div>

            {{-- Subscription option --}}
            <div class="bg-white rounded-2xl p-6 shadow border border-green-50">
                <h2 class="font-extrabold text-gray-800 text-lg mb-4">📦 Subscription Option</h2>
                <label class="flex items-start gap-3 p-4 border-2 border-green-200 bg-green-50 rounded-xl cursor-pointer">
                    <input type="checkbox" name="subscribe" value="1" class="mt-1 accent-green-600">
                    <div>
                        <p class="font-bold text-sm text-gray-800">Subscribe & Save 15%</p>
                        <p class="text-xs text-gray-600">Get automatic monthly deliveries of this order. Pause or cancel anytime.</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-6 shadow border border-green-50 sticky top-20">
                <h2 class="font-extrabold text-gray-800 text-lg mb-4">Order Summary</h2>
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Items</span><span>KES {{ number_format($total) }}</span>
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
                <p class="text-center text-xs text-gray-400 mt-3">🔒 Your information is secure and encrypted.</p>
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-center gap-2 text-xs text-gray-500">
                    <span class="text-xl">📱</span><span class="text-xl">💳</span><span class="text-xl">🅿️</span>
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
