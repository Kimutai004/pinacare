@extends('storefront.layouts.app')
@section('title', 'Shop All Products')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-green-800">Shop Our Products</h1>
            <p class="text-gray-600 mt-1">Eco-friendly diapers, wipes & bundles for your little one.</p>
        </div>
        <div class="flex gap-2 mt-4 md:mt-0">
            <a href="{{ route('store.shop') }}" class="px-4 py-2 rounded-full text-sm font-bold {{ !request('category') ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">All</a>
            @foreach(['diaper','wipe','bundle'] as $cat)
                <a href="{{ route('store.shop', ['category' => $cat]) }}"
                   class="px-4 py-2 rounded-full text-sm font-bold {{ request('category') === $cat ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ ucfirst($cat) }}s
                </a>
            @endforeach
        </div>
    </div>

    @if($products->count())
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        @foreach($products as $product)
        <a href="{{ route('store.product', $product) }}" class="group bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden border border-green-50">
            <div class="aspect-square bg-gradient-to-br from-green-50 to-white flex items-center justify-center p-6">
                <span class="text-6xl group-hover:scale-110 transition-transform">{{ $product->category === 'diaper' ? '🩲' : ($product->category === 'wipe' ? '🧻' : '📦') }}</span>
            </div>
            <div class="p-4">
                <span class="text-xs font-bold text-green-600 uppercase tracking-wider">{{ $product->category }}{{ $product->size ? ' · Size '.$product->size : '' }}</span>
                <h3 class="font-bold text-gray-800 mt-1 text-sm md:text-base">{{ $product->name }}</h3>
                <div class="flex items-center justify-between mt-3">
                    <span class="text-lg font-extrabold text-green-700">KES {{ number_format($product->price) }}</span>
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $products->links() }}</div>
    @else
    <div class="text-center py-16">
        <span class="text-6xl">🌱</span>
        <h3 class="text-xl font-bold text-gray-600 mt-4">No products found</h3>
        <p class="text-gray-500">Try a different category or check back soon.</p>
    </div>
    @endif
</section>

{{-- ===== Subscription CTA ===== --}}
<section class="bg-green-700 text-white py-12 mt-10">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-5xl">📦</span>
        <h2 class="text-2xl md:text-3xl font-extrabold mt-4">Never Run Out of Diapers!</h2>
        <p class="text-green-100 mt-2 max-w-lg mx-auto">Subscribe & Save — get monthly deliveries at discounted prices. Pause or cancel anytime.</p>
        <a href="{{ route('store.shop') }}" class="inline-block mt-6 px-6 py-3 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 transition">Start Subscription</a>
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
