<header class="bg-white shadow-sm">
    <div class="px-6 py-4 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Welcome, {{ Auth::guard('admin')->user()->name }}</h2>
            <p class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</p>
        </div>

        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.settings') }}" class="text-sm font-medium text-green-700 hover:text-green-900">
                ⚙️ Settings
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
