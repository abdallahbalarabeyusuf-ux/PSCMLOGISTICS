<footer class="bg-primary-900 text-gray-200">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="flex items-center gap-2">
                    <x-logo-mark class="h-10 w-10 text-white" text-size="text-sm" />
                    <span class="leading-tight">
                        <span class="block text-lg font-extrabold text-white">PSCM</span>
                        <span class="block text-[9px] font-semibold tracking-wide text-secondary-300">PRIME SUPPLY CHAIN MANAGEMENT</span>
                    </span>
                </div>
                <p class="mt-4 text-sm text-gray-400">We are committed to providing fast, reliable and secure logistics solutions you can trust.</p>
                <div class="mt-4 flex gap-3">
                    @foreach (['Facebook' => 'f', 'Instagram' => 'ig', 'LinkedIn' => 'in'] as $label => $short)
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white" title="{{ $label }}">{{ $short }}</span>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-wide text-white">Quick Links</h4>
                <ul class="mt-4 space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-secondary-300">Home</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-secondary-300">Services</a></li>
                    <li><a href="{{ route('shipments.track') }}" class="hover:text-secondary-300">Track Shipment</a></li>
                    <li><a href="{{ route('pricing') }}" class="hover:text-secondary-300">Pricing</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-secondary-300">About Us</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-wide text-white">Services</h4>
                <ul class="mt-4 space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('services') }}#dispatch" class="hover:text-secondary-300">Dispatch Delivery</a></li>
                    <li><a href="{{ route('services') }}#cargo" class="hover:text-secondary-300">Cargo &amp; Haulage</a></li>
                    <li><a href="{{ route('services') }}#business" class="hover:text-secondary-300">Business Logistics</a></li>
                    <li><a href="{{ route('services') }}#warehousing" class="hover:text-secondary-300">Warehousing</a></li>
                    <li><a href="{{ route('rider-application.create') }}" class="hover:text-secondary-300">Become a Rider</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-wide text-white">Contact Info</h4>
                <ul class="mt-4 space-y-2 text-sm text-gray-400">
                    <li>📞 {{ config('company.phone_1') }}</li>
                    <li>📞 {{ config('company.phone_2') }}</li>
                    <li>📍 {{ config('company.address') }}</li>
                    <li>✉️ {{ config('company.email') }}</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-6 text-xs text-gray-400 sm:flex-row">
            <p>&copy; {{ date('Y') }} PSCM Logistics. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="{{ route('contact') }}" class="hover:text-secondary-300">Contact Us</a>
                <a href="{{ route('admin.login') }}" class="hover:text-secondary-300">Admin</a>
            </div>
        </div>
    </div>
</footer>
