@extends('storefront.layouts.app')
@section('title', 'Your Cart')
@section('robots', 'noindex, nofollow')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-12">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-green-800">Your Cart</h1>
            <p class="text-gray-500 mt-1">Secure checkout · M-Pesa, Card, PayPal</p>
        </div>
        <div class="flex items-center gap-2 mt-4 sm:mt-0 text-sm">
            <span class="w-8 h-8 rounded-full bg-green-700 text-white flex items-center justify-center font-bold">1</span>
            <span class="text-gray-500">Cart</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-gray-400"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            <span class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold">2</span>
            <span class="text-gray-400">Checkout</span>
        </div>
    </div>

    @if(count($products) > 0)
    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Items --}}
        <div class="lg:col-span-2 space-y-4" id="cartItems">
            @foreach($products as $item)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-green-50 flex items-center gap-4 hover:shadow-lg transition" data-product-id="{{ $item['product']->id }}" data-product-price="{{ $item['product']->price }}">
<div class="w-20 h-20 rounded-xl {{ $item['product']->category === 'diaper' ? 'bg-green-50' : ($item['product']->category === 'wipe' ? 'bg-blue-50' : 'bg-amber-50') }} {{ $item['product']->category === 'diaper' ? 'text-green-600' : ($item['product']->category === 'wipe' ? 'text-blue-600' : 'text-amber-600') }} flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if($item['product']->image_url)
                        <img src="{{ asset($item['product']->image_url) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                    @else
                    @include('storefront.partials.icons', ['icon' => $item['product']->category === 'diaper' ? 'diaper' : ($item['product']->category === 'wipe' ? 'wipe' : 'bundle'), 'class' => 'w-10 h-10'])
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('store.product', $item['product']) }}" class="font-bold text-gray-800 hover:text-green-700">{{ $item['product']->name }}</a>
                    @if($item['product']->size)<span class="text-xs text-gray-500 block">Size {{ $item['product']->size }}</span>@endif
                    <span class="text-sm text-gray-500">KES {{ number_format($item['product']->price) }} each</span>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center border border-gray-300 rounded-full bg-white">
                            <button type="button" class="qty-decrease px-2.5 py-1 text-gray-600 hover:text-green-700">−</button>
                            <input type="number" class="qty-input w-10 text-center text-sm font-bold border-0 focus:outline-none" value="{{ $item['qty'] }}" min="0" data-original-qty="{{ $item['qty'] }}">
                            <button type="button" class="qty-increase px-2.5 py-1 text-gray-600 hover:text-green-700">+</button>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('store.cart.remove', $item['product']->id) }}" onsubmit="return confirm('Remove this item?')">
                        @csrf
                        <button class="text-xs text-red-500 hover:underline inline-flex items-center gap-1">
                            @include('storefront.partials.icons', ['icon' => 'cart', 'class' => 'w-3.5 h-3.5'])
                            Remove
                        </button>
                    </form>
                </div>
                <div class="text-right w-28">
                    <p class="font-extrabold text-green-700 text-lg cart-subtotal">KES {{ number_format($item['subtotal']) }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-green-50 sticky top-20">
                <h2 class="font-extrabold text-gray-800 text-lg mb-5 flex items-center gap-2">
                    <span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'cart', 'class' => 'w-5 h-5'])</span>
                    Order Summary
                </h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal (<span id="cartItemCount">{{ count($products) }}</span> items)</span><span class="font-bold text-gray-800" id="subtotalAmount">KES {{ number_format($total) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Delivery</span><span class="text-green-600 font-bold">Free in Nairobi</span>
                    </div>
<div class="flex justify-between text-gray-600">
                        <span>Impact</span><span class="text-green-600 font-bold">0 CO₂ waste</span>
                    </div>
                </div>
                <div class="border-t border-gray-200 my-5 pt-5 flex justify-between font-extrabold text-gray-900 text-lg">
                    <span>Total</span><span id="totalAmount">KES {{ number_format($total) }}</span>
                </div>
                <a href="{{ route('store.checkout') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3.5 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow flex-1">
                    Proceed to Checkout
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop') }}" class="flex items-center justify-center w-full px-6 py-3 mt-3 border-2 border-green-600 text-green-700 font-bold rounded-full hover:bg-green-50 transition">Continue Shopping</a>
                <p class="text-center text-xs text-gray-400 mt-4"><span class="inline-flex items-center gap-1 justify-center"><span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'lock', 'class' => 'w-3.5 h-3.5'])</span>Secure checkout</span></p>
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-center gap-3 text-gray-500">
                    <span class="w-5 h-5 text-green-600">@include('storefront.partials.icons', ['icon' => 'mpesa', 'class' => 'w-full h-full'])</span>
                    <span class="w-5 h-5 text-blue-600">@include('storefront.partials.icons', ['icon' => 'card', 'class' => 'w-full h-full'])</span>
                    <span class="w-5 h-5 text-blue-700">@include('storefront.partials.icons', ['icon' => 'paypal', 'class' => 'w-full h-full'])</span>
                </div>
            </div>
        </div>
    </div>
    @else
    {{-- Empty state --}}
    <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-green-50 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-52 h-52 rounded-full bg-green-50"></div>
        <div class="relative">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 text-green-600 flex items-center justify-center mx-auto shadow-lg">
                <span class="w-12 h-12">@include('storefront.partials.icons', ['icon' => 'bundle', 'class' => 'w-full h-full'])</span>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-700 mt-6">Your cart is empty</h2>
            <p class="text-gray-500 mt-2 max-w-md mx-auto">Discover our eco-friendly diapers, wipes, and bundles and start making a difference today.</p>
            <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-2 mt-7 px-8 py-3.5 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow-lg">
                Shop Now
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
    @endif
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.getElementById('cartItems');
    if (!cartItems) return;
    
    // Handle quantity button clicks and updates
    cartItems.querySelectorAll('[data-product-id]').forEach(item => {
        const qtyInput = item.querySelector('.qty-input');
        const decreaseBtn = item.querySelector('.qty-decrease');
        const increaseBtn = item.querySelector('.qty-increase');
        const updateBtn = item.querySelector('.qty-update');
        const productId = item.getAttribute('data-product-id');
        const productPrice = parseFloat(item.getAttribute('data-product-price'));
        const subtotalEl = item.querySelector('.cart-subtotal');
        
        function updateSubtotal() {
            const qty = parseInt(qtyInput.value) || 0;
            const subtotal = qty * productPrice;
            subtotalEl.textContent = 'KES ' + subtotal.toLocaleString('en-US');
        }
        
        function updateTotal() {
            let totalAmount = 0;
            let itemCount = 0;
            
            cartItems.querySelectorAll('[data-product-id]').forEach(cartItem => {
                const qty = parseInt(cartItem.querySelector('.qty-input').value) || 0;
                const price = parseFloat(cartItem.getAttribute('data-product-price'));
                if (qty > 0) {
                    totalAmount += qty * price;
                    itemCount += qty;
                }
            });
            
            document.getElementById('subtotalAmount').textContent = 'KES ' + totalAmount.toLocaleString('en-US');
            document.getElementById('totalAmount').textContent = 'KES ' + totalAmount.toLocaleString('en-US');
            document.getElementById('cartItemCount').textContent = itemCount;
        }
        
        decreaseBtn.addEventListener('click', () => {
            const currentQty = parseInt(qtyInput.value) || 0;
            if (currentQty > 0) {
                qtyInput.value = currentQty - 1;
                updateSubtotal();
                updateTotal();
            }
        });
        
        increaseBtn.addEventListener('click', () => {
            qtyInput.value = (parseInt(qtyInput.value) || 0) + 1;
            updateSubtotal();
            updateTotal();
        });
        
        updateBtn.addEventListener('click', () => {
            const qty = qtyInput.value;
            const updateForm = document.createElement('form');
            updateForm.method = 'POST';
            updateForm.action = '{{ route("store.cart.update", "") }}' + '/' + productId;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('input[name="_token"]')?.value || '';
            
            const qtyInputField = document.createElement('input');
            qtyInputField.type = 'hidden';
            qtyInputField.name = 'qty';
            qtyInputField.value = qty;
            
            updateForm.appendChild(csrfInput);
            updateForm.appendChild(qtyInputField);
            document.body.appendChild(updateForm);
            updateForm.submit();
        });
    });
});
</script>
@endpush

@push('scripts')
<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(){
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>
@endpush
