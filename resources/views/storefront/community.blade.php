@extends('storefront.layouts.app')
@section('title', 'Community')
@section('meta_description', 'Join the PINACARE community — read our eco-parenting blog, share your story, and subscribe for sustainable baby care tips delivered to your inbox.')

@section('content')
{{-- ===== 1. HERO ===== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-800 text-white">
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-green-400/15 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-emerald-300/15 blur-3xl"></div>
    <div class="relative max-w-4xl mx-auto px-4 text-center py-16 md:py-20">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur border border-white/20 text-green-200 text-xs font-bold tracking-widest uppercase rounded-full mb-6">
            <span class="text-green-300">@include('storefront.partials.icons', ['icon' => 'user', 'class' => 'w-4 h-4'])</span>
            Our Community
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">Parenting Tips, Real Stories, <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-emerald-200">and a Tribe of Eco-Conscious Families</span></h1>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none text-[#faf8f3]">
        <svg viewBox="0 0 1440 60" fill="currentColor" preserveAspectRatio="none" class="w-full h-10 md:h-14">
            <path d="M0,32L48,29.3C96,27,192,21,288,24C384,27,480,37,576,37.3C672,37,768,27,864,26.7C960,27,1056,37,1152,34.7C1248,32,1344,21,1392,16L1440,11L1440,60L0,60Z"></path>
        </svg>
    </div>
</section>

{{-- ===== 2. BLOG + TESTIMONIALS ===== --}}
<section class="py-16 md:py-20 bg-[#faf8f3]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Blog posts --}}
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-green-800 flex items-center gap-2">
                        <span class="w-9 h-9 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">@include('storefront.partials.icons', ['icon' => 'email', 'class' => 'w-5 h-5'])</span>
                        Parenting Blog
                    </h2>
                </div>
                @forelse($posts as $post)
                <article class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-green-50 hover:shadow-lg hover:border-green-200 transition">
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                        <span class="font-bold text-green-600 uppercase flex items-center gap-1.5">
                            @include('storefront.partials.icons', ['icon' => 'calendar', 'class' => 'w-3.5 h-3.5'])
                            {{ $post->created_at->format('M d, Y') }}
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-5 h-5 rounded-full bg-green-100 text-green-700 flex items-center justify-center">@include('storefront.partials.icons', ['icon' => 'avatar', 'class' => 'w-3 h-3'])</span>
                            {{ $post->author?->name ?? 'PINACARE Team' }}
                        </span>
                    </div>
                    <a href="{{ route('store.blog', $post->slug) }}">
                        <h3 class="text-xl font-extrabold text-gray-800 hover:text-green-700 transition">{{ $post->title }}</h3>
                    </a>
                    <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ Str::limit(strip_tags($post->content), 160) }}</p>
                    <a href="{{ route('store.blog', $post->slug) }}" class="inline-flex items-center gap-1 mt-3 text-green-700 text-sm font-bold hover:gap-2 transition-all">
                        Read Full Article
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </article>
                @empty
                <p class="text-gray-500">No blog posts yet. Check back soon!</p>
                @endforelse

                @if($posts->hasPages())
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>

            {{-- Testimonials --}}
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-green-800 mb-6 flex items-center gap-2">
                    <span class="w-9 h-9 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">@include('storefront.partials.icons', ['icon' => 'star', 'class' => 'w-5 h-5'])</span>
                    Parent Reviews
                </h2>
                <div class="space-y-4">
                    @forelse($testimonials as $t)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-green-50 hover:shadow-lg transition">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex text-yellow-400 gap-0.5">
                                @for($i=0;$i<5;$i++)
                                <svg viewBox="0 0 20 20" fill="{{ $i < $t->rating ? 'currentColor' : '#d1d5db' }}" class="w-4 h-4"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="w-7 h-7 rounded-full bg-green-100 text-green-700 flex items-center justify-center">@include('storefront.partials.icons', ['icon' => 'avatar', 'class' => 'w-4 h-4'])</span>
                        </div>
                        <p class="text-sm text-gray-600 italic">"{{ $t->content }}"</p>
                        <p class="text-sm font-bold text-green-700 mt-2">— {{ $t->customer?->name ?? 'Verified Parent' }}</p>
                    </div>
                    @empty
                    <p class="text-gray-500">No testimonials yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 3. WHATSAPP + NEWSLETTER CTA ===== --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 grid md:grid-cols-2 gap-8">
        <div class="relative overflow-hidden bg-gradient-to-br from-green-600 to-emerald-700 text-white rounded-3xl p-8 shadow-xl">
            <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10"></div>
            <div class="relative">
                <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center mb-4">
                    <span class="w-8 h-8">@include('storefront.partials.icons', ['icon' => 'whatsapp', 'class' => 'w-full h-full'])</span>
                </div>
                <h3 class="text-2xl font-extrabold">Join Our WhatsApp Group</h3>
                <p class="text-green-100 mt-2 text-sm">Chat with other eco-parents, get tips, and share your journey.</p>
                <a href="https://chat.whatsapp.com/" target="_blank" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 transition">
                    Join Now
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                </a>
            </div>
        </div>
        <div class="relative overflow-hidden bg-gradient-to-br from-green-800 to-emerald-900 text-white rounded-3xl p-8 shadow-xl">
            <div class="absolute -bottom-10 -right-10 w-40 h-40 rounded-full bg-white/10"></div>
            <div class="relative">
                <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center mb-4">
                    <span class="w-8 h-8">@include('storefront.partials.icons', ['icon' => 'email', 'class' => 'w-full h-full'])</span>
                </div>
                <h3 class="text-2xl font-extrabold">Newsletter</h3>
                <p class="text-green-200 mt-2 text-sm">Monthly eco-parenting tips, product drops, and impact updates.</p>
                <form method="POST" action="{{ route('store.newsletter') }}" class="mt-6 flex gap-2">
                    @csrf
                    <input type="email" name="email" placeholder="Your email" required class="flex-1 px-4 py-2.5 rounded-full text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <button class="px-5 py-2.5 bg-green-500 text-white font-bold rounded-full hover:bg-green-400 transition text-sm">Join</button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- ===== 4. INFLUENCERS ===== --}}
<section class="py-16 bg-[#faf8f3]">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-xs font-extrabold tracking-widest uppercase rounded-full mb-5">Collaborations</span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-green-800">Mommy Blogger Stories</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mt-3 mb-10">We collaborate with parenting influencers to share real experiences using PINACARE products.</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach(['Wanjiku','Amina','Grace','Zawadi'] as $i => $name)
            <div class="group bg-white rounded-2xl p-6 text-center border border-green-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 text-green-700 border-2 border-green-200 flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                    @include('storefront.partials.icons', ['icon' => 'avatar', 'class' => 'w-8 h-8'])
                </div>
                <p class="font-bold text-gray-800 mt-3">{{ $name }}</p>
                <p class="text-xs text-gray-500">Eco-Parenting Blogger</p>
                <span class="inline-flex items-center gap-1 mt-2 text-yellow-400">
                    @for($s=0;$s<5;$s++)<svg viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                </span>
            </div>
            @endforeach
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
