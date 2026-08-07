@php
$navItems = [
    ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10'],
    ['route' => 'admin.products.index', 'match' => 'admin/products*', 'label' => 'Products', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
    ['route' => 'admin.orders.index', 'match' => 'admin/orders*', 'label' => 'Orders', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
    ['route' => 'admin.subscriptions.index', 'match' => 'admin/subscriptions*', 'label' => 'Subscriptions', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2L15 20'],
    ['route' => 'admin.customers.index', 'match' => 'admin/customers*', 'label' => 'Customers', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
    ['route' => 'admin.impact.index', 'match' => 'admin/impact*', 'label' => 'Impact Metrics', 'icon' => 'M12 21a9 9 0 100-18 9 9 0 000 18zm3-11a3 3 0 10-6 0 3 3 0 006 0zM3 4l3.5 3.5M21 4l-3.5 3.5M9 21l1.5-3.5M15 21l-1.5-3.5M12 6v2'],
    ['route' => 'admin.blog.index', 'match' => 'admin/blog*', 'label' => 'Blog Posts', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
    ['route' => 'admin.testimonials.index', 'match' => 'admin/testimonials*', 'label' => 'Testimonials', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
    ['route' => 'admin.settings', 'match' => 'admin/settings*', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z'],
];
@endphp

<!-- Mobile top bar with hamburger -->
<div class="md:hidden bg-green-800 text-white px-4 py-3 flex items-center justify-between shadow-lg fixed top-0 left-0 right-0 z-40">
    <div class="flex items-center space-x-2">
        <button id="sidebarToggle" type="button" class="text-white hover:text-lime-300 focus:outline-none" aria-label="Toggle menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold leading-tight">PINACARE</h1>
            <p class="text-green-200 text-[10px] leading-tight">Eco Admin</p>
        </div>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.settings') }}" class="text-white hover:text-lime-300">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="text-white hover:text-lime-300">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- Off-canvas mobile menu -->
<div id="mobileSidebar" class="fixed inset-0 z-50 hidden md:hidden">
    <div id="sidebarOverlay" class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="absolute inset-y-0 left-0 w-72 bg-green-800 text-white shadow-2xl flex flex-col transform -translate-x-full transition-transform duration-300">
        <!-- Brand -->
        <div class="px-6 py-6 border-b border-green-700 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-full bg-green-500 flex items-center justify-center shadow-lg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                        <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">PINACARE</h1>
                    <p class="text-green-200 text-xs">Eco Admin · Circular Economy</p>
                </div>
            </div>
            <button id="sidebarClose" type="button" class="text-green-200 hover:text-white focus:outline-none" aria-label="Close menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            @foreach($navItems as $item)
                @php
                    $active = $item['match'] == 'admin.dashboard'
                        ? request()->routeIs($item['route'])
                        : request()->is($item['match']);
                @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group {{ $active ? 'bg-white/15 text-white shadow-inner' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                         class="w-5 h-5 mr-3 {{ $active ? 'text-lime-300' : 'text-green-200 group-hover:text-lime-300' }}">
                        <path d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                    @if($item['match'] == 'admin/impact*')
                        <span class="ml-auto w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span>
                    @endif
                </a>
            @endforeach

            <div class="pt-4 mt-4 border-t border-green-700">
                <div class="flex items-center gap-2 text-green-100 text-xs opacity-90 mb-1 px-3">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-lime-300">
                        <path d="M3 3v5h5M21 3v5h-5M3 21v-5h5M21 21v-5h-5M3 8a9 9 0 015-8M21 8a9 9 0 01-5 8M8 21a9 9 0 01-5-8"/>
                    </svg>
                    Recycle · Reuse · Renew
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Desktop sidebar -->
<aside class="hidden md:flex w-80 bg-green-800 text-white flex-col fixed inset-y-0 left-0 z-30 shadow-2xl">
    <!-- Brand -->
    <div class="px-6 py-6 border-b border-green-700 flex items-center space-x-3">
        <div class="w-11 h-11 rounded-full bg-green-500 flex items-center justify-center shadow-lg">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold tracking-tight">PINACARE</h1>
            <p class="text-green-200 text-xs flex items-center gap-1">
                <svg viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3"><path d="M12 22c5.5 0 9-4 9-9.5C21 5 15 2 5 2c0 8 2.5 12 7 20z" opacity="0.5"/></svg>
                Eco Admin · Circular Economy
            </p>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        @foreach($navItems as $item)
            @php
                $active = $item['match'] == 'admin.dashboard'
                    ? request()->routeIs($item['route'])
                    : request()->is($item['match']);
            @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group {{ $active ? 'bg-white/15 text-white shadow-inner' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                     class="w-5 h-5 mr-3 {{ $active ? 'text-lime-300' : 'text-green-200 group-hover:text-lime-300' }}">
                    <path d="{{ $item['icon'] }}"/>
                </svg>
                {{ $item['label'] }}
                @if($item['match'] == 'admin/impact*')
                    <span class="ml-auto w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span>
                @endif
            </a>
        @endforeach

        <div class="pt-4 mt-4 border-t border-green-700">
            <div class="flex items-center gap-2 text-green-100 text-xs opacity-90 mb-1 px-3">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-lime-300">
                    <path d="M3 3v5h5M21 3v5h-5M3 21v-5h5M21 21v-5h-5M3 8a9 9 0 015-8M21 8a9 9 0 01-5 8M8 21a9 9 0 01-5-8"/>
                </svg>
                Recycle · Reuse · Renew
            </div>
        </div>
    </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('sidebarClose');
    const overlay = document.getElementById('sidebarOverlay');
    const sidebar = document.getElementById('mobileSidebar');
    const drawer = sidebar ? sidebar.querySelector('div.absolute.inset-y-0') : null;

    if (!toggle || !sidebar || !drawer) return;

    function openSidebar() {
        sidebar.classList.remove('hidden');
        requestAnimationFrame(() => drawer.classList.remove('-translate-x-full'));
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        drawer.classList.add('-translate-x-full');
        setTimeout(() => {
            sidebar.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    toggle.addEventListener('click', openSidebar);
    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);
});
</script>

