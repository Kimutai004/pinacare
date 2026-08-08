<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sustainable Baby Care') | PINACARE</title>
    <meta name="description" content="PINACARE — where sustainability meets baby care. 100% biodegradable, baby-safe, circular economy diapers and wipes.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .loader-hidden { opacity: 0; visibility: hidden; transition: opacity 30s ease; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        .float { animation: float 30s ease-in-out infinite; }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        .spin-slow { animation: spin-slow 2.5s linear infinite; }
    </style>
</head>
<body class="bg-green-50 bg-[#faf8f3] text-gray-800 antialiased">

    <!-- ===== Full-page Loader ===== -->
    <div id="pageLoader" class="fixed inset-0 z-[100] bg-green-800 flex flex-col items-center justify-center space-y-5">
        <div class="relative w-24 h-24 float">
            <div class="absolute inset-0 rounded-full border-4 border-green-200"></div>
            <div class="absolute inset-0 rounded-full border-4 border-t-green-600 border-green-200 spin-slow"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <img src="{{ asset('logo.png') }}" alt="PINACARE Logo" class="w-32 h-auto mx-auto mb-2">
            </div>
        </div>
        <div class="text-center">
            <p class="text-sm text-white mt-1">Where Sustainability Meets Baby Care</p>
        </div>
        <div class="w-48 h-1.5 bg-green-100 rounded-full overflow-hidden">
            <div class="h-full bg-green-500 rounded-full progress-bar" style="width:0%"></div>
        </div>
    </div>

    @include('storefront.partials.navbar')

    <main id="mainContent">
        @if(session('success'))
            <div class="max-w-6xl mx-auto px-4 mt-6">
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-6xl mx-auto px-4 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm" role="alert">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="max-w-6xl mx-auto px-4 mt-6">
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl text-sm">
                    <ul>
                        @foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('storefront.partials.footer')

    <script>
        window.addEventListener('load', function () {
            const loader = document.getElementById('pageLoader');
            const bar = document.querySelector('.progress-bar');
            if (bar) bar.style.width = '100%';
            setTimeout(function () {
                if (loader) loader.classList.add('loader-hidden');
                setTimeout(function () { if (loader) loader.remove(); }, 600);
            }, 700);
        });
        // Fallback in case load already fired
        setTimeout(function () {
            const loader = document.getElementById('pageLoader');
            if (loader) { loader.classList.add('loader-hidden'); setTimeout(function () { loader.remove(); }, 600); }
        }, 3000);
    </script>
    @stack('scripts')
</body>
</html>
