@extends('storefront.layouts.app')
@section('title', 'Community')

@section('content')
{{-- Hero --}}
<section class="bg-green-700 text-white py-14">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-5xl">👩‍👧</span>
        <h1 class="text-4xl font-extrabold mt-4">Our Community</h1>
        <p class="text-green-100 mt-3 text-lg">Parenting tips, real stories, and a tribe of eco-conscious families.</p>
    </div>
</section>

{{-- Blog + Testimonials --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Blog posts --}}
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-extrabold text-green-800 mb-6">Parenting Blog</h2>
                @forelse($posts as $post)
                <article class="bg-green-50 rounded-2xl p-6 mb-6 border border-green-100">
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                        <span class="font-bold text-green-600 uppercase">{{ $post->created_at->format('M d, Y') }}</span>
                        <span>{{ $post->author?->name ?? 'PINACARE Team' }}</span>
                    </div>
                    <a href="{{ route('store.blog', $post->slug) }}">
                        <h3 class="text-xl font-extrabold text-gray-800 hover:text-green-700 transition">{{ $post->title }}</h3>
                    </a>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit(strip_tags($post->content), 160) }}</p>
                    <a href="{{ route('store.blog', $post->slug) }}" class="inline-block mt-3 text-green-700 text-sm font-bold hover:underline">Read Full Article →</a>
                </article>
                @empty
                <p class="text-gray-500">No blog posts yet. Check back soon!</p>
                @endforelse
            </div>

            {{-- Testimonials --}}
            <div>
                <h2 class="text-2xl font-extrabold text-green-800 mb-6">Parent Reviews</h2>
                <div class="space-y-4">
                    @forelse($testimonials as $t)
                    <div class="bg-white rounded-2xl p-5 shadow border border-green-50">
                        <div class="flex text-yellow-400 mb-2">@for($i=0;$i<5;$i++)<svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 {{ $i < $t->rating ? '' : 'text-gray-300' }}"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor</div>
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

{{-- WhatsApp / Newsletter --}}
<section class="py-16 bg-green-50/50">
    <div class="max-w-4xl mx-auto px-4 grid md:grid-cols-2 gap-8">
        <div class="bg-green-600 text-white rounded-3xl p-8 text-center">
            <span class="text-5xl">💬</span>
            <h3 class="text-2xl font-extrabold mt-4">Join Our WhatsApp Group</h3>
            <p class="text-green-100 mt-2 text-sm">Chat with other eco-parents, get tips, and share your journey.</p>
            <a href="https://chat.whatsapp.com/" target="_blank" class="inline-block mt-6 px-6 py-3 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 transition">Join Now</a>
        </div>
        <div class="bg-green-800 text-white rounded-3xl p-8 text-center">
            <span class="text-5xl">📧</span>
            <h3 class="text-2xl font-extrabold mt-4">Newsletter</h3>
            <p class="text-green-200 mt-2 text-sm">Monthly eco-parenting tips, product drops, and impact updates.</p>
            <form method="POST" action="{{ route('store.newsletter') }}" class="mt-6 flex gap-2">
                @csrf
                <input type="email" name="email" placeholder="Your email" required class="flex-1 px-4 py-2.5 rounded-full text-gray-800 text-sm focus:outline-none">
                <button class="px-5 py-2.5 bg-green-500 text-white font-bold rounded-full hover:bg-green-400 transition text-sm">Join</button>
            </form>
        </div>
    </div>
</section>

{{-- Influencer collaborations --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-extrabold text-green-800 mb-8">Mommy Blogger Stories</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-10">We collaborate with parenting influencers to share real experiences using PINACARE products.</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach(['👩‍🦰','👩🏻','👱‍♀️','👩🏾‍🦱'] as $i => $avatar)
            <div class="bg-green-50 rounded-2xl p-6 text-center border border-green-100">
                <div class="text-5xl mx-auto w-16 h-16 rounded-full bg-white shadow flex items-center justify-center">{{ $avatar }}</div>
                <p class="font-bold text-gray-800 mt-3">Mommy Blogger {{ $i + 1 }}</p>
                <p class="text-xs text-gray-500">Eco-Parenting</p>
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
