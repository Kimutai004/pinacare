@extends('storefront.layouts.app')
@section('title', $post->title)
@section('meta_description', \App\Support\Seo::excerpt($post->content))
@section('og_type', 'article')

@section('content')
{{-- ===== 1. ARTICLE HEADER ===== --}}
<section class="py-12 md:py-16 bg-white border-b border-gray-100">
    <div class="max-w-4xl mx-auto px-4">
        {{-- Navigation --}}
        <div class="mb-8">
            <a href="{{ route('store.community') }}" class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 transition font-semibold text-sm">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-4 h-4"><path d="M15 19l-7-7 7-7"/></svg>
                Back to Community
            </a>
        </div>

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight max-w-3xl">
            {{ $post->title }}
        </h1>
    </div>
</section>

{{-- ===== 2. ARTICLE CONTENT ===== --}}
<section class="py-20 md:py-28 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Main content --}}
            <div class="lg:col-span-2">
                {{-- Article body with better typography --}}
                <article class="prose prose-lg max-w-none">
                    <div class="text-gray-700 leading-relaxed space-y-8 text-lg">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </article>

                {{-- Article footer --}}
                <div class="mt-16 pt-8 border-t border-gray-200">
                    {{-- Author card --}}
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50/50 rounded-2xl p-8 border border-green-100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                {{ substr($post->author?->name ?? 'P', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">{{ $post->author?->name ?? 'PINACARE Team' }}</h4>
                                <p class="text-sm text-green-700">PINACARE Editorial Team</p>
                            </div>
                        </div>
                        <p class="text-gray-700 text-sm">
                            We're passionate about sustainable baby care and eco-friendly living. Learn more about our mission to protect the planet while keeping your little ones comfortable and safe.
                        </p>
                    </div>

                    {{-- Share section --}}
                    <div class="mt-12">
                        <h4 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-green-600"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.06c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.057.21-.088.43-.088.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg>
                            Share Article
                        </h4>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5c-.563-.074-1.396-.074-2.59-.074-2.833 0-4.41 1.842-4.41 5.041z"/></svg>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white font-semibold rounded-full hover:bg-black transition shadow-md hover:shadow-lg">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7a10.6 10.6 0 01-9-5.5z"/></svg>
                                Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition shadow-md hover:shadow-lg">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.411-2.389-1.477-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-3.055 2.237-4.673 5.965-3.584 9.578.5 1.563 1.378 3.017 2.601 4.242 1.224 1.224 2.679 2.1 4.241 2.6 1.895.603 3.954.321 5.734-.857 1.78-1.179 2.904-3.046 2.637-5.148-.267-2.102-1.912-3.808-3.978-4.275zm0 0"/></svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                {{-- Quick info card --}}
                <div class="sticky top-20 space-y-8">
                    {{-- Article Info --}}
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50/50 rounded-2xl p-6 border border-green-100 shadow-sm">
                        <h4 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Article Info</h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-semibold text-green-700 uppercase tracking-wider">Published</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $post->created_at->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-green-700 uppercase tracking-wider">Category</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">Eco-Friendly Living</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-green-700 uppercase tracking-wider">Reading Time</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</p>
                            </div>
                        </div>
                    </div>

                    {{-- CTA Card --}}
                    <div class="bg-gradient-to-br from-green-600 to-emerald-700 text-white rounded-2xl p-6 shadow-lg border border-green-500/30">
                        <div class="w-12 h-12 rounded-full bg-white/10 backdrop-blur border border-white/20 flex items-center justify-center mb-4">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                        <h5 class="font-bold text-lg mb-2">Eco-Conscious?</h5>
                        <p class="text-green-100 text-sm mb-6">Join thousands of parents making a sustainable difference for their babies.</p>
                        <a href="{{ route('store.shop') }}" class="inline-block w-full py-2.5 bg-white text-green-700 font-bold rounded-lg hover:bg-green-50 transition text-center">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 3. RELATED ARTICLES / NEXT STEPS ===== --}}
<section class="py-20 md:py-28 bg-gradient-to-br from-green-50 to-emerald-50/50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Explore More Insights</h2>
            <p class="text-lg text-gray-600">Discover more about sustainable baby care and eco-friendly living</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Card 1 --}}
            <a href="{{ route('store.community') }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-green-100 hover:border-green-300">
                <div class="h-48 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center overflow-hidden">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20 text-green-600 group-hover:scale-110 transition transform duration-300">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-green-700 transition">Join Our Community</h3>
                    <p class="text-gray-600 text-sm mb-4">Connect with eco-conscious parents and share your journey</p>
                    <div class="flex items-center gap-2 text-green-600 font-semibold">
                        Read More <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 group-hover:translate-x-1 transition"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

            {{-- Card 2 --}}
            <a href="{{ route('store.shop') }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-green-100 hover:border-green-300">
                <div class="h-48 bg-gradient-to-br from-blue-100 to-green-100 flex items-center justify-center overflow-hidden">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20 text-blue-600 group-hover:scale-110 transition transform duration-300">
                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-0.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l0.03-.12 0.9-1.63h7.45c0.75 0 1.41-.41 1.75-1.03l3.58-6.49c0.08-.14 0.12-.31 0.12-.48 0-0.55-0.45-1-1-1H5.21l-0.94-2H1zm16 16c-1.1 0-1.99 0.9-1.99 2s0.89 2 1.99 2 2-0.9 2-2-0.9-2-2-2z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-green-700 transition">Shop Our Products</h3>
                    <p class="text-gray-600 text-sm mb-4">Discover our full range of eco-friendly baby care solutions</p>
                    <div class="flex items-center gap-2 text-green-600 font-semibold">
                        Explore <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 group-hover:translate-x-1 transition"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

            {{-- Card 3 --}}
            <a href="{{ route('store.impact') }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-green-100 hover:border-green-300">
                <div class="h-48 bg-gradient-to-br from-emerald-100 to-green-100 flex items-center justify-center overflow-hidden">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20 text-emerald-600 group-hover:scale-110 transition transform duration-300">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-green-700 transition">Our Impact</h3>
                    <p class="text-gray-600 text-sm mb-4">Learn about the positive impact we're making on the planet</p>
                    <div class="flex items-center gap-2 text-green-600 font-semibold">
                        Discover <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 group-hover:translate-x-1 transition"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- ===== 4. FINAL CTA SECTION ===== --}}
<section class="py-20 md:py-28 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <div class="relative overflow-hidden bg-gradient-to-br from-[#0b3d2e] via-[#0b5a2e] to-[#145a20] text-white rounded-3xl p-12 md:p-16 shadow-2xl">
            {{-- Decorative elements --}}
            <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-emerald-500/20 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-60 h-60 rounded-full bg-green-500/20 blur-3xl"></div>

            {{-- Content --}}
            <div class="relative text-center">
                <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur border border-white/20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-green-300">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Ready for Sustainable Baby Care?</h2>
                <p class="text-lg text-green-100/90 mb-8 max-w-2xl mx-auto">
                    Join thousands of eco-conscious parents who've already made the switch to PINACARE. Every purchase helps protect our planet.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('store.shop') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-green-400 text-[#0b3d2e] font-bold rounded-lg hover:bg-green-300 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        Shop PINACARE Now
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-5 h-5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('store.community') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-green-300 text-green-300 font-bold rounded-lg hover:bg-white/10 transition">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
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
