<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <!-- Eco decorative icon -->
<div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                <svg viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M21 12v0a9 9 0 01-9 9v0a9 9 0 01-9-9v0a9 9 0 019-9v0a9 9 0 019 9z"/>
                    <path d="M12 8v4l3 3"/>
                    <circle cx="12" cy="12" r="9"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Welcome, {{ Auth::guard('admin')->user()->name }}</h2>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span>{{ now()->format('l, F j, Y') }}</span>
                    <span class="w-px h-3 bg-gray-300"></span>
                    <!-- Baby & eco indicators -->
                    <span class="flex items-center gap-1 text-green-600">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-3.5 h-3.5">
                            <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                        </svg>
                        Eco-Friendly
                    </span>
                    <span class="w-px h-3 bg-gray-300"></span>
                    <span class="flex items-center gap-1 text-blue-600">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-3.5 h-3.5">
                            <path d="M12 22c5.5 0 9-4 9-9.5C21 5 15 2 5 2c0 8 2.5 12 7 20z"/>
                        </svg>
                        Baby-Safe
                    </span>
                    <span class="w-px h-3 bg-gray-300"></span>
                    <span class="flex items-center gap-1 text-amber-600">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-3.5 h-3.5">
                            <path d="M3 3v5h5M21 3v5h-5M3 21v-5h5M21 21v-5h-5M3 8a9 9 0 015-8M21 8a9 9 0 01-5 8M8 21a9 9 0 01-5-8"/>
                        </svg>
                        Circular Economy
                    </span>
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-5">
            <a href="{{ route('admin.settings') }}" class="flex items-center gap-2 text-sm font-medium text-green-700 hover:text-green-900 transition-colors">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-800 transition-colors">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>

