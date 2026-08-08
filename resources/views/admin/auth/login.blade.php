<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | PINACARE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-green-900 min-h-screen flex items-center justify-center p-4">
    <!-- Decorative eco circles -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full bg-green-500/10"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-teal-400/10"></div>
        <div class="absolute top-16 right-24 w-4 h-4 rounded-full bg-lime-400/40 animate-pulse"></div>
        <div class="absolute bottom-24 left-16 w-3 h-3 rounded-full bg-teal-300/40 animate-pulse" style="animation-delay: 0.3s"></div>
    </div>

    <div class="relative w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2 flex-col md:flex-row">
        <!-- Left: eco branding panel -->
<div class="hidden md:flex flex-col justify-between bg-green-700 text-white p-10 relative overflow-hidden">
            <div class="absolute right-6 top-6 w-16 h-16 rounded-full bg-lime-300/20"></div>
            <div class="absolute bottom-8 -left-8 w-24 h-24 rounded-full bg-white/10"></div>

            <div class="flex items-center space-x-3">
<div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                        <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                    </svg>
                </div>
                <span class="text-lg font-bold">PINACARE</span>
            </div>

            <div>
                <h2 class="text-3xl font-bold leading-tight mb-4">Nurturing babies &<br/>protecting the planet.</h2>

                <ul class="space-y-4">
                    <li class="flex items-center gap-3 bg-white/10 rounded-xl p-3">
                        <span class="w-10 h-10 rounded-full bg-green-500/30 flex items-center justify-center flex-shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5">
                                <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                                <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold text-sm">Eco-Friendly</p>
                            <p class="text-green-100 text-xs">100% biodegradable materials</p>
                        </div>
                    </li>
                    <li class="flex items-center gap-3 bg-white/10 rounded-xl p-3">
                        <span class="w-10 h-10 rounded-full bg-blue-400/30 flex items-center justify-center flex-shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5">
                                <path d="M12 22c5.5 0 9-4 9-9.5C21 5 15 2 5 2c0 8 2.5 12 7 20z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold text-sm">Baby-Safe</p>
                            <p class="text-green-100 text-xs">Hypoallergenic & dermatologist tested</p>
                        </div>
                    </li>
                    <li class="flex items-center gap-3 bg-white/10 rounded-xl p-3">
                        <span class="w-10 h-10 rounded-full bg-amber-400/30 flex items-center justify-center flex-shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5">
                                <path d="M3 3v5h5M21 3v5h-5M3 21v-5h5M21 21v-5h-5M3 8a9 9 0 015-8M21 8a9 9 0 01-5 8M8 21a9 9 0 01-5-8"/>
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold text-sm">Circular Economy</p>
                            <p class="text-green-100 text-xs">Recycle · Reuse · Renew</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="flex items-center gap-2 text-green-100 text-xs">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="w-4 h-4">
                    <path d="M12 22c5.5 0 9-4 9-9.5C21 5 15 2 5 2c0 8 2.5 12 7 20z"/>
                </svg>
                Made for a greener tomorrow
            </div>
        </div>

        <!-- Right: login form -->
        <div class="p-8 md:p-12 md:col-span-1 flex items-center">
            <div class="w-full">
                <div class="text-center md:text-left mb-8 md:hidden">
                    <div class="inline-flex items-center gap-2">
<div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                <path d="M11 20A7 7 0 019.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
                                <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-green-800">PINACARE</h1>
                    </div>
                </div>

                <h2 class="text-3xl font-bold text-gray-800 md:text-center md:text-left mb-1">Admin Login</h2>
                <p class="text-gray-500 mb-8 md:text-center md:text-left">Sign in to manage PINACARE operations</p>

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <ul class="text-sm">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5">
                                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" required
                                   class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center text-gray-600">
                            <input type="checkbox" name="remember" class="mr-2 h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500"> Remember me
                        </label>
                    </div>

<button type="submit"
                            class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 rounded-xl transition shadow-lg">
                        Sign In
                    </button>
                </form>

                <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4">
                        <path d="M3 3v5h5M21 3v5h-5M3 21v-5h5M21 21v-5h-5M3 8a9 9 0 015-8M21 8a9 9 0 01-5 8M8 21a9 9 0 01-5-8"/>
                    </svg>
                    Committed to a sustainable future
                </div>
            </div>
        </div>
    </div>
</body>
</html>

