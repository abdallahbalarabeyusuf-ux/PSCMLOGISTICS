<header x-data="{ mobileOpen: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100 shadow-sm">

    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
            <x-logo-mark class="h-11 w-11 text-primary" text-size="text-sm" />
            <span class="leading-tight">
                <span class="block text-xl font-extrabold text-primary">PSCM</span>
                <span class="block text-[10px] font-semibold tracking-wide text-secondary">PRIME SUPPLY CHAIN MANAGEMENT</span>
            </span>
        </a>

        <div class="hidden lg:flex items-center gap-8 text-sm font-semibold text-gray-700">
            <a href="{{ route('home') }}" class="hover:text-primary {{ request()->routeIs('home') ? 'text-primary' : '' }}">Home</a>
            <a href="{{ route('services') }}" class="hover:text-primary {{ request()->routeIs('services') ? 'text-primary' : '' }}">Services</a>
            <a href="{{ route('pricing') }}" class="hover:text-primary {{ request()->routeIs('pricing') ? 'text-primary' : '' }}">Pricing</a>
            <a href="{{ route('shipments.track') }}" class="hover:text-primary {{ request()->routeIs('shipments.track*') ? 'text-primary' : '' }}">Track Shipment</a>
            <a href="{{ route('about') }}" class="hover:text-primary {{ request()->routeIs('about') ? 'text-primary' : '' }}">About Us</a>
            <a href="{{ route('contact') }}" class="hover:text-primary {{ request()->routeIs('contact') ? 'text-primary' : '' }}">Contact</a>
        </div>

        <div class="hidden lg:flex items-center gap-3 shrink-0">
            @auth
                <a href="{{ route('customer.dashboard') }}" class="text-sm font-semibold text-primary hover:text-primary-700">My Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-primary">Login</a>
            @endauth
            <a href="{{ route('shipments.create') }}" class="btn-secondary">Request Pickup</a>
        </div>

        <button @click="mobileOpen = !mobileOpen" class="lg:hidden inline-flex items-center justify-center rounded-lg p-2 text-gray-600 hover:bg-gray-100" aria-label="Toggle menu">
            <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            <svg x-show="mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </nav>

    <div x-show="mobileOpen" x-cloak x-transition @click.outside="mobileOpen = false" class="lg:hidden border-t border-gray-100 bg-white px-4 py-4 space-y-3 text-sm font-semibold text-gray-700" style="display:none">
        <a href="{{ route('home') }}" class="block hover:text-primary">Home</a>
        <a href="{{ route('services') }}" class="block hover:text-primary">Services</a>
        <a href="{{ route('pricing') }}" class="block hover:text-primary">Pricing</a>
        <a href="{{ route('shipments.track') }}" class="block hover:text-primary">Track Shipment</a>
        <a href="{{ route('about') }}" class="block hover:text-primary">About Us</a>
        <a href="{{ route('contact') }}" class="block hover:text-primary">Contact</a>
        <a href="{{ route('rider-application.create') }}" class="block hover:text-primary">Become a Rider</a>
        <hr class="border-gray-100">
        @auth
            <a href="{{ route('customer.dashboard') }}" class="block text-primary">My Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="block text-primary">Login</a>
        @endauth
        <a href="{{ route('shipments.create') }}" class="btn-secondary w-full">Request Pickup</a>
    </div>
</header>

