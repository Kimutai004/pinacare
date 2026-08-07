@extends('storefront.layouts.app')
@section('title', $post->title)

@section('content')
<section class="max-w-3xl mx-auto px-4 py-12">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('store.community') }}" class="hover:text-green-700">← Back to Community</a>
    </nav>
    <span class="text-xs font-bold text-green-600 uppercase">{{ $post->created_at->format('F d, Y') }}</span>
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mt-2">{{ $post->title }}</h1>
    <p class="text-gray-500 mt-2 text-sm">By {{ $post->author?->name ?? 'PINACARE Team' }}</p>

    <div class="mt-8 bg-green-50 rounded-2xl p-8 border border-green-100 leading-relaxed text-gray-700 prose">
        {!! nl2br(e($post->content)) !!}
    </div>

    <div class="mt-10 bg-green-700 text-white rounded-3xl p-8 text-center">
        <span class="text-4xl">🌱</span>
        <h3 class="text-2xl font-extrabold mt-3">Ready to Join the Eco-Revolution?</h3>
        <a href="{{ route('store.shop') }}" class="inline-block mt-5 px-6 py-3 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 transition">Shop PINACARE</a>
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
