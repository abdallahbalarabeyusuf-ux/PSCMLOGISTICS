<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PSCM - Prime Supply Chain Management')</title>
    <meta name="description" content="@yield('meta_description', 'Fast, reliable and secure logistics & dispatch services across Kano State and beyond.')">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="PSCM Logistics">
    <meta property="og:title" content="@yield('title', 'PSCM - Prime Supply Chain Management')">
    <meta property="og:description" content="@yield('meta_description', 'Fast, reliable and secure logistics & dispatch services across Kano State and beyond.')">
    <meta property="og:image" content="@yield('og_image', asset('images/port-crane-sunset.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'PSCM - Prime Supply Chain Management')">
    <meta name="twitter:description" content="@yield('meta_description', 'Fast, reliable and secure logistics & dispatch services across Kano State and beyond.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/port-crane-sunset.jpg'))">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased font-sans text-gray-800 bg-white">

    @include('partials.site-navbar')

    <main>
        @if (session('status'))
            <div class="mx-auto max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
                <div class="rounded-lg bg-secondary-50 border border-secondary-200 px-4 py-3 text-sm text-secondary-700">
                    {{ session('status') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    @include('partials.site-footer')
    @include('partials.whatsapp-widget')

    @stack('scripts')
</body>
</html>
