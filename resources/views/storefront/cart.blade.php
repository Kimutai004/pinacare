@extends('storefront.layouts.app')
@section('title', 'Your Cart')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-extrabold text-green-800 mb-8">Your Cart</h1>

    @if(count($products) > 0)
    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            @foreach($products as $item)
            <div class="bg-white rounded-2xl p-5 shadow flex items-center gap-4 border border-green-50">
                <div class="w-20 h-20 rounded-xl bg-green-50 flex items-center justify-center text-4xl flex-shrink-0">
                    {{ $item['product']->category === 'diaper' ? '🩲' : ($item['product']->category === 'wipe' ? '🧻' : '📦') }}
                </div>
                <div class="flex-1">
                    <a href="{{ route('store.product', $item['product']) }}" class="font-bold text-gray-800 hover:text-green-700">{{ $item['product']->name }}</a>
                    @if($item['product']->size)<span class="text-xs text-gray-500 block">Size {{ $item['product']->size }}</span>@endif
                    <span class="text-sm text-gray-500">KES {{ number_format($item['product']->price) }} each</span>
                </div>
                <form method="POST" action="{{ route('store.cart.update', $item['product']->id) }}" class="flex items-center gap-2">
                    @csrf
                    <div class="flex items-center border border-gray-300 rounded-full">
                        <button type="button" onclick="this.parentNode.querySelector('input').stepDown();this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-2 py-1 text-gray-600">−</button>
                        <input type="number" name="qty" value="{{ $item['qty'] }}" min="0" class="w-10 text-center text-sm font-bold border-0 focus:outline-none">
                        <button type="button" onclick="this.parentNode.querySelector('input').stepUp();this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-2 py-1 text-gray-600">+</button>
                    </div>
                    <button type="submit" class="text-xs text-green-700 font-bold hover:underline">Update</button>
                </form>
                <div class="text-right">
                    <p class="font-extrabold text-green-700">KES {{ number_format($item['subtotal']) }}</p>
                    <form method="POST" action="{{ route('store.cart.remove', $item['product']->id) }}" onsubmit="return confirm('Remove this item?')">
                        @csrf
                        <button class="text-xs text-red-500 hover:underline">Remove</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-6 shadow border border-green-50 sticky top-20">
                <h2 class="font-extrabold text-gray-800 text-lg mb-4">Order Summary</h2>
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Subtotal</span><span>KES {{ number_format($total) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Delivery</span><span class="text-green-600 font-bold">Free in Nairobi</span>
                </div>
                <div class="border-t border-gray-200 my-4 pt-4 flex justify-between font-extrabold text-gray-800">
                    <span>Total</span><span>KES {{ number_format($total) }}</span>
                </div>
                <a href="{{ route('store.checkout') }}" class="block text-center w-full px-6 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow">Proceed to Checkout</a>
                <a href="{{ route('store.shop') }}" class="block text-center w-full px-6 py-3 mt-3 border-2 border-green-600 text-green-700 font-bold rounded-full hover:bg-green-50 transition">Continue Shopping</a>
                <p class="text-center text-xs text-gray-400 mt-4">🔒 Secure checkout · M-Pesa, Card, PayPal</p>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-20 bg-white rounded-3xl shadow border border-green-50">
        <span class="text-7xl">🛒</span>
        <h2 class="text-2xl font-extrabold text-gray-700 mt-4">Your cart is empty</h2>
        <p class="text-gray-500 mt-2">Discover our eco-friendly products and start making a difference.</p>
        <a href="{{ route('store.shop') }}" class="inline-block mt-6 px-8 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition">Shop Now</a>
    </div>
    @endif
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>
@endpush
