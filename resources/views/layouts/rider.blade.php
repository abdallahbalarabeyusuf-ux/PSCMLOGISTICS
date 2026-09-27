<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rider Portal') - PSCM</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased font-sans text-gray-800 bg-accent">

    @if (auth('admin')->check())
        <div class="flex items-center justify-between gap-3 bg-yellow-400 px-4 py-2 text-sm font-semibold text-yellow-900">
            <span>👁️ Viewing as {{ auth('rider')->user()->name }}</span>
            <form method="POST" action="{{ route('impersonate.stop') }}">
                @csrf
                <button type="submit" class="rounded-md bg-yellow-900 px-3 py-1 text-xs font-bold text-yellow-50 hover:bg-yellow-800">Return to Admin</button>
            </form>
        </div>
    @endif

    <header class="sticky top-0 z-10 flex h-14 items-center justify-between border-b border-gray-200 bg-primary-900 px-4">
        <span class="flex items-center gap-2 text-white">
            <x-logo-mark class="h-8 w-8 text-white" text-size="text-[10px]" />
            <span class="font-bold">PSCM Rider</span>
        </span>
        <form method="POST" action="{{ route('rider.logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-gray-300 hover:text-white">Log Out</button>
        </form>
    </header>

    <main class="mx-auto max-w-lg px-4 py-6">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-secondary-200 bg-secondary-50 px-4 py-3 text-sm text-secondary-700">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
