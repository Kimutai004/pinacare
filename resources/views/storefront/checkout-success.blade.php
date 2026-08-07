@extends('storefront.layouts.app')
@section('title', 'Order Confirmed!')

@section('content')
<section class="max-w-3xl mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl shadow-lg border border-green-50 p-8 md:p-12 text-center">
        <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto">
            <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10"><path d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="text-3xl font-extrabold text-green-800 mt-6">Order Confirmed! 🎉</h1>
        <p class="text-gray-600 mt-3">Thank you for choosing PINACARE. You're making a real difference for your baby and the planet.</p>

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
                    <p class="font-bold text-gray-800 uppercase">{{ $order->payment_method }}</p>
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

        @if($order->items->count())
        <div class="mt-6 bg-white rounded-2xl border border-gray-100 p-6 text-left">
            <h3 class="font-extrabold text-gray-800 mb-4">Items</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-700">{{ $item->product?->name }} × {{ $item->quantity }}</span>
                    <span class="font-bold text-gray-800">KES {{ number_format($item->price * $item->quantity) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('store.shop') }}" class="px-6 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition">Continue Shopping</a>
            <a href="{{ route('store.impact') }}" class="px-6 py-3 border-2 border-green-600 text-green-700 font-bold rounded-full hover:bg-green-50 transition">See Your Impact</a>
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
