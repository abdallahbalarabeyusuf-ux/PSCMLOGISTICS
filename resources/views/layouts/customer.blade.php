<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Dashboard') - PSCM</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-gray-800 bg-accent" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-64 transform bg-primary-900 text-white transition-transform lg:static lg:translate-x-0">
            <div class="flex h-16 items-center gap-2 px-6 border-b border-white/10">
                <x-logo-mark class="h-9 w-9 text-white" text-size="text-xs" />
                <span class="font-extrabold text-lg">PSCM</span>
            </div>
            <nav class="mt-4 space-y-1 px-3 text-sm font-medium">
                <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('customer.dashboard') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('shipments.create') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-gray-300 hover:bg-white/5 hover:text-white">
                    Request Pickup
                </a>
                <a href="{{ route('shipments.track') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-gray-300 hover:bg-white/5 hover:text-white">
                    Track Shipment
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('profile.edit') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    My Profile
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-gray-300 hover:bg-white/5 hover:text-white">
                    Back to Website
                </a>
            </nav>
            <div class="absolute bottom-0 w-full border-t border-white/10 p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <div @click="sidebarOpen = false" x-show="sidebarOpen" x-cloak class="fixed inset-0 z-30 bg-black/40 lg:hidden" style="display:none"></div>

        {{-- Main content --}}
        <div class="flex-1 lg:pl-0">
            @if (auth('admin')->check())
                <div class="flex items-center justify-between gap-3 bg-yellow-400 px-4 py-2 text-sm font-semibold text-yellow-900">
                    <span>👁️ You are viewing as {{ auth()->user()->name }} (admin impersonation)</span>
                    <form method="POST" action="{{ route('impersonate.stop') }}">
                        @csrf
                        <button type="submit" class="rounded-md bg-yellow-900 px-3 py-1 text-xs font-bold text-yellow-50 hover:bg-yellow-800">Return to Admin</button>
                    </form>
                </div>
            @endif
            <header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <h1 class="text-lg font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
                </div>
                <span class="text-sm font-medium text-gray-600">{{ auth()->user()->name }}</span>
            </header>

            <main class="p-4 sm:p-6">
                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-secondary-200 bg-secondary-50 px-4 py-3 text-sm text-secondary-700">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
