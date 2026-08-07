<aside class="w-64 bg-green-800 text-white flex flex-col fixed inset-y-0 left-0 z-30 hidden md:flex">
    <div class="px-6 py-6 border-b border-green-700">
        <h1 class="text-2xl font-bold">PINACARE</h1>
        <p class="text-green-300 text-sm">Admin Panel</p>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
            <span class="mr-3">📊</span> Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/products*') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
            <span class="mr-3">📦</span> Products
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/orders*') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
            <span class="mr-3">🛒</span> Orders
        </a>

        <a href="{{ route('admin.subscriptions.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/subscriptions*') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
            <span class="mr-3">🔁</span> Subscriptions
        </a>

        <a href="{{ route('admin.customers.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/customers*') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
            <span class="mr-3">👤</span> Customers
        </a>

        <a href="{{ route('admin.impact.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/impact*') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
            <span class="mr-3">🌱</span> Impact Metrics
        </a>

        <a href="{{ route('admin.blog.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/blog*') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
            <span class="mr-3">✍️</span> Blog Posts
        </a>

        <a href="{{ route('admin.testimonials.index') }}"
           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/testimonials*') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
            <span class="mr-3">💬</span> Testimonials
        </a>

        <div class="pt-4 mt-4 border-t border-green-700">
            <a href="{{ route('admin.settings') }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/settings*') ? 'bg-green-700 text-white' : 'text-green-200 hover:bg-green-700 hover:text-white' }}">
                <span class="mr-3">⚙️</span> Settings
            </a>
        </div>
    </nav>
</aside>

<!-- Mobile sidebar menu -->
<div class="md:hidden flex items-center justify-between bg-green-800 text-white px-4 py-3">
    <div>
        <h1 class="text-xl font-bold">PINACARE</h1>
        <p class="text-green-300 text-xs">Admin Panel</p>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.settings') }}" class="text-white hover:text-green-300">⚙️</a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="text-white hover:text-green-300">Logout</button>
        </form>
    </div>
</div>
