@extends('storefront.layouts.app')
@section('title', $post->title)

@section('content')
{{-- ===== 1. ARTICLE HERO ===== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-800 text-white">
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-green-400/15 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-emerald-300/15 blur-3xl"></div>
    <div class="relative max-w-4xl mx-auto px-4 py-16 md:py-20">
        <nav class="text-sm text-green-200 mb-6">
            <a href="{{ route('store.community') }}" class="inline-flex items-center gap-1.5 hover:text-white transition">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                Back to Community
            </a>
        </nav>
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-green-200 text-xs font-bold tracking-widest uppercase rounded-full mb-5">
            @include('storefront.partials.icons', ['icon' => 'calendar', 'class' => 'w-4 h-4'])
            {{ $post->created_at->format('F d, Y') }}
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight">{{ $post->title }}</h1>
        <div class="flex items-center gap-3 mt-6">
            <span class="w-11 h-11 rounded-full bg-white/15 backdrop-blur border border-white/25 text-green-200 flex items-center justify-center">@include('storefront.partials.icons', ['icon' => 'avatar', 'class' => 'w-6 h-6'])</span>
            <div>
                <p class="font-bold">By {{ $post->author?->name ?? 'PINACARE Team' }}</p>
                <p class="text-xs text-green-200">PINACARE Editorial</p>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none text-[#faf8f3]">
        <svg viewBox="0 0 1440 60" fill="currentColor" preserveAspectRatio="none" class="w-full h-10 md:h-14">
            <path d="M0,32L48,29.3C96,27,192,21,288,24C384,27,480,37,576,37.3C672,37,768,27,864,26.7C960,27,1056,37,1152,34.7C1248,32,1344,21,1392,16L1440,11L1440,60L0,60Z"></path>
        </svg>
    </div>
</section>

{{-- ===== 2. ARTICLE BODY ===== --}}
<section class="py-14 bg-[#faf8f3]">
    <div class="max-w-3xl mx-auto px-4">
        {{-- Key highlights --}}
        <div class="grid grid-cols-3 gap-4 mb-10">
            <div class="bg-white rounded-2xl p-4 text-center border border-green-50 shadow-sm">
                <span class="w-8 h-8 text-green-600 mx-auto block">@include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-full h-full'])</span>
                <p class="text-xs font-bold text-gray-700 mt-2">Eco-Friendly</p>
            </div>
            <div class="bg-white rounded-2xl p-4 text-center border border-green-50 shadow-sm">
                <span class="w-8 h-8 text-blue-600 mx-auto block">@include('storefront.partials.icons', ['icon' => 'baby', 'class' => 'w-full h-full'])</span>
                <p class="text-xs font-bold text-gray-700 mt-2">Baby-Safe</p>
            </div>
            <div class="bg-white rounded-2xl p-4 text-center border border-green-50 shadow-sm">
                <span class="w-8 h-8 text-amber-600 mx-auto block">@include('storefront.partials.icons', ['icon' => 'recycle', 'class' => 'w-full h-full'])</span>
                <p class="text-xs font-bold text-gray-700 mt-2">Sustainable</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-green-50 leading-relaxed text-gray-700 text-lg">
            {!! nl2br(e($post->content)) !!}
        </div>

        {{-- Share --}}
        <div class="flex items-center justify-center gap-4 mt-10">
            <span class="text-sm font-bold text-gray-500">Share this article:</span>
            @foreach(['facebook','x','whatsapp'] as $social)
            <a href="#" class="w-10 h-10 rounded-full bg-gradient-to-br from-green-600 to-emerald-700 text-white flex items-center justify-center hover:scale-110 hover:shadow-lg transition-all duration-300" aria-label="Share on {{ ucfirst($social) }}">
                @include('storefront.partials.icons', ['icon' => $social, 'class' => 'w-5 h-5'])
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 3. CTA ===== --}}
<section class="py-14 bg-white">
    <div class="max-w-3xl mx-auto px-4">
        <div class="relative overflow-hidden bg-gradient-to-br from-green-700 to-emerald-800 text-white rounded-3xl p-10 text-center shadow-xl">
            <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full bg-white/5"></div>
            <div class="relative">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur border border-white/20 flex items-center justify-center mx-auto mb-5">
                    <span class="w-8 h-8">@include('storefront.partials.icons', ['icon' => 'leaf', 'class' => 'w-full h-full'])</span>
                </div>
                <h3 class="text-2xl md:text-3xl font-extrabold">Ready to Join the Eco-Revolution?</h3>
                <p class="text-green-100 mt-2">Eco-friendly, baby-safe products delivered to your door.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center mt-7">
                    <a href="{{ route('store.shop') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 transition shadow-lg">
                        Shop PINACARE
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('store.community') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 border-2 border-white/60 text-white font-bold rounded-full hover:bg-white/10 transition">
                        @include('storefront.partials.icons', ['icon' => 'chat', 'class' => 'w-4 h-4'])
                        Join Community
                    </a>
                </div>
            </div>
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
