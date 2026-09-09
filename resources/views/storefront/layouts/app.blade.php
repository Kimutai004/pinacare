<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        // ===== SEO metadata (page-overridable) =====
        $seoPageTitle   = view()->hasSection('title') ? trim(view()->yieldContent('title')) : '';
        $seoTitle       = ($seoPageTitle === '' ? 'Sustainable Baby Care' : $seoPageTitle) . ' | PINACARE';
        $seoDescription = trim(view()->yieldContent('meta_description', 'PINACARE — where sustainability meets baby care. 100% biodegradable, baby-safe, circular economy diapers and wipes.'));
        $seoKeywords    = trim(view()->yieldContent('meta_keywords', 'biodegradable diapers, baby wipes, eco-friendly baby care, sustainable nappies, circular economy, baby care Kenya'));
        $seoCanonical   = view()->hasSection('canonical') ? trim(view()->yieldContent('canonical')) : request()->fullUrl();
        $seoRobots      = trim(view()->yieldContent('robots', 'index, follow, max-image-preview:large'));
        $seoOgType      = trim(view()->yieldContent('og_type', 'website'));
        $seoOgTitle     = view()->hasSection('og_title') ? trim(view()->yieldContent('og_title')) : $seoTitle;
        $siteLogo       = asset('logo.png');
        if (! str_starts_with($siteLogo, 'http')) {
            $siteLogo = request()->schemeAndHttpHost() . $siteLogo;
        }
        $seoOgImage     = view()->hasSection('og_image') ? trim(view()->yieldContent('og_image')) : $siteLogo;
        $siteRoot       = request()->root();
    @endphp

    <title>{{ $seoTitle }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- ===== SEO: description / keywords / robots / canonical ===== --}}
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="robots" content="{{ $seoRobots }}">
    <meta name="author" content="PINACARE">
    <meta name="theme-color" content="#0b3d2e">
    <link rel="canonical" href="{{ $seoCanonical }}">

    {{-- ===== Open Graph ===== --}}
    <meta property="og:site_name" content="PINACARE">
    <meta property="og:type" content="{{ $seoOgType }}">
    <meta property="og:title" content="{{ $seoOgTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoOgImage }}">
    <meta property="og:locale" content="en_US">

    {{-- ===== Twitter / X cards ===== --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoOgTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoOgImage }}">

    {{-- ===== Structured data: Organization + WebSite (site-wide) ===== --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "Organization",
                "@id": "{{ $siteRoot }}#organization",
                "name": "PINACARE",
                "url": "{{ $siteRoot }}",
                "logo": "{{ $siteLogo }}",
                "sameAs": [
                    "https://www.facebook.com/share/1JikxbVgyW",
                    "https://x.com/pinacarelimited"
                ]
            },
            {
                "@type": "WebSite",
                "@id": "{{ $siteRoot }}#website",
                "name": "PINACARE",
                "url": "{{ $siteRoot }}"
            }
        ]
    }
    </script>

    {{-- Page-specific structured data (Product / Article / BreadcrumbList) --}}
    @isset($pageJsonLd)
    <script type="application/ld+json">
{!! $pageJsonLd !!}
    </script>
    @endisset

    {{-- Performance: compiled Tailwind CSS (replaces the Tailwind CDN) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Webfonts: preconnect + display=swap to avoid flash-of-invisible-text --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    @stack('head')
</head>
<body class="bg-green-50 bg-[#faf8f3] text-gray-800 antialiased">

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

    @stack('scripts')
</body>
</html>