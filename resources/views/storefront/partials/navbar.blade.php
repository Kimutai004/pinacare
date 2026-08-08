@php
    $cart = session()->get('cart', []);
    $cartCount = array_sum($cart);
    $navLinks = [
        ['route' => 'store.home', 'label' => 'Home'],
        ['route' => 'store.shop', 'label' => 'Shop'],
        ['route' => 'store.about', 'label' => 'About'],
        ['route' => 'store.impact', 'label' => 'Impact'],
        ['route' => 'store.community', 'label' => 'Community'],
        ['route' => 'store.partners', 'label' => 'Healthcare'],
        ['route' => 'store.contact', 'label' => 'Contact'],
    ];
@endphp
<header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-green-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('store.home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('logo-green.png') }}" alt="Pinacare Logo" class="h-40 w-auto">
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden lg:flex items-center space-x-6">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="text-sm font-semibold {{ request()->routeIs($link['route']) ? 'text-green-700' : 'text-gray-600 hover:text-green-700' }} transition-colors">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Right actions -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('store.cart') }}" class="relative p-2 rounded-full text-gray-600 hover:text-green-700 hover:bg-green-50 transition-colors">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-green-600 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('store.shop') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-full hover:bg-green-700 transition-colors shadow">
                    Shop Now
                </a>
                <!-- Mobile hamburger -->
                <button id="mobileMenuBtn" type="button" class="lg:hidden p-2 rounded-full text-gray-600 hover:text-green-700 hover:bg-green-50" aria-label="Open menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile drawer -->
    <div id="mobileMenu" class="lg:hidden hidden bg-white border-t border-green-100 shadow-lg">
        <nav class="px-4 py-3 space-y-1">
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="block px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs($link['route']) ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-green-50' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="{{ route('store.shop') }}" class="block px-3 py-2.5 rounded-lg text-sm font-bold bg-green-600 text-white text-center">Shop Now</a>
        </nav>
    </div>
</header>

@stack('nav-scripts')
