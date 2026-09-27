<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PSCM')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-gray-800 bg-accent">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10">
        <a href="{{ route('home') }}" class="mb-6 flex items-center gap-2">
            <x-logo-mark class="h-12 w-12 text-primary" text-size="text-base" />
            <span class="leading-tight">
                <span class="block text-2xl font-extrabold text-primary">PSCM</span>
                <span class="block text-[10px] font-semibold tracking-wide text-secondary">PRIME SUPPLY CHAIN MANAGEMENT</span>
            </span>
        </a>

        <div class="w-full sm:max-w-md rounded-xl bg-white px-6 py-8 shadow-lg sm:px-8">
            @yield('content')
        </div>

        <p class="mt-6 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-primary">&larr; Back to website</a>
        </p>
    </div>
</body>
</html>
