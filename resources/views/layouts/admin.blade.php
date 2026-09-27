<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - PSCM</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased font-sans text-gray-800 bg-accent" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-64 transform bg-primary-900 text-white transition-transform lg:static lg:translate-x-0 overflow-y-auto">
            <div class="flex h-16 items-center gap-2 px-6 border-b border-white/10">
                <x-logo-mark class="h-9 w-9 text-white" text-size="text-xs" />
                <span class="font-extrabold text-lg">PSCM Admin</span>
            </div>
            <nav class="mt-4 space-y-1 px-3 text-sm font-medium pb-24">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.shipments.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('admin.shipments.*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Shipments
                </a>
                <a href="{{ route('admin.riders.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('admin.riders.*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Riders
                </a>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('admin.customers.*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Customers
                </a>
                <a href="{{ route('admin.rider-applications.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('admin.rider-applications.*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Rider Applications
                </a>
                <a href="{{ route('admin.pricing-zones.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('admin.pricing-zones.*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Pricing Zones
                </a>
                <a href="{{ route('admin.contact-messages.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('admin.contact-messages.*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Contact Messages
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-gray-300 hover:bg-white/5 hover:text-white">
                    View Website
                </a>
            </nav>
            <div class="absolute bottom-0 w-full border-t border-white/10 p-3 bg-primary-900">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <div @click="sidebarOpen = false" x-show="sidebarOpen" x-cloak class="fixed inset-0 z-30 bg-black/40 lg:hidden" style="display:none"></div>

        <div class="flex-1">
            <header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <h1 class="text-lg font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
                </div>
                <span class="text-sm font-medium text-gray-600">{{ auth('admin')->user()->name }}</span>
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

    @stack('scripts')
</body>
</html>
