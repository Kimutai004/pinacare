@extends('storefront.layouts.app')
@section('title', 'Order Confirmed!')

@section('content')
<section class="relative max-w-3xl mx-auto px-4 py-16">
    {{-- Confetti accent --}}
    <div class="absolute -top-10 -left-10 w-40 h-40 rounded-full bg-green-50 blur-sm"></div>
    <div class="absolute -bottom-10 -right-10 w-40 h-40 rounded-full bg-emerald-50 blur-sm"></div>

    <div class="relative bg-white rounded-[2rem] shadow-xl border border-green-50 p-8 md:p-12 text-center overflow-hidden">
        {{-- Success check --}}
        <div class="relative w-24 h-24 mx-auto">
            <div class="absolute inset-0 rounded-full bg-green-100 animate-ping opacity-40"></div>
            <div class="relative w-24 h-24 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 text-white flex items-center justify-center shadow-lg">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12"><path d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold text-green-800 mt-6 flex items-center justify-center gap-2">
            <span class="text-green-500">@include('storefront.partials.icons', ['icon' => 'confetti', 'class' => 'w-8 h-8'])</span>
            Order Confirmed!
        </h1>
        <p class="text-gray-600 mt-3 text-lg">Thank you for choosing PINACARE. You're making a real difference for your baby and the planet.</p>

        {{-- Order details --}}
        <div class="mt-8 bg-green-50 rounded-2xl p-6 text-left">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Order ID</p>
                    <p class="font-bold text-gray-800">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Status</p>
                    <p class="font-bold text-green-600 uppercase">{{ $order->status }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Customer</p>
                    <p class="font-bold text-gray-800">{{ $order->customer?->name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Payment</p>
                    <p class="font-bold text-gray-800 uppercase flex items-center gap-1.5">
                        @include('storefront.partials.icons', ['icon' => $order->payment_method === 'mpesa' ? 'mpesa' : ($order->payment_method === 'paypal' ? 'paypal' : 'card'), 'class' => 'w-4 h-4'])
                        {{ $order->payment_method }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Total</p>
                    <p class="font-bold text-green-700">KES {{ number_format($order->total_amount) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Order Date</p>
                    <p class="font-bold text-gray-800">{{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Items --}}
        @if($order->items->count())
        <div class="mt-6 bg-white rounded-2xl border border-gray-100 p-6 text-left">
            <h3 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'box', 'class' => 'w-5 h-5'])</span>
                Items
            </h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-700 flex items-center gap-2">
                        @if($item->product?->image_url)
                            <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-8 h-8 rounded-lg object-cover">
                        @else
                        <span class="w-6 h-6 text-{{ $item->product?->category === 'diaper' ? 'green' : ($item->product?->category === 'wipe' ? 'blue' : 'amber') }}-600">
                            @include('storefront.partials.icons', ['icon' => $item->product?->category === 'diaper' ? 'diaper' : ($item->product?->category === 'wipe' ? 'wipe' : 'bundle'), 'class' => 'w-full h-full'])
                        </span>
                        @endif
                        {{ $item->product?->name }} × {{ $item->quantity }}
                    </span>
                    <span class="font-bold text-gray-800">KES {{ number_format($item->price * $item->quantity) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Impact note --}}
        <div class="mt-6 flex items-center justify-center gap-2 text-sm text-green-700 bg-green-50 border border-green-100 rounded-2xl p-4">
            <span class="text-green-600">@include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-5 h-5'])</span>
            <span>This order is helping keep <strong>~30 nappies</strong> out of landfills. Thank you!</span>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('store.shop') }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition">
                Continue Shopping
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('store.impact') }}" class="flex items-center justify-center gap-2 px-6 py-3 border-2 border-green-600 text-green-700 font-bold rounded-full hover:bg-green-50 transition">
                @include('storefront.partials.icons', ['icon' => 'globe', 'class' => 'w-4 h-4'])
                See Your Impact
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
