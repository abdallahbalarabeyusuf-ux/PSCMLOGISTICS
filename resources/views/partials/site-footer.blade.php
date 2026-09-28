<footer class="relative bg-[#061833] text-gray-200">
    {{-- Green top accent line matching PSCM brand --}}
    <div class="h-1.5 w-full bg-[#00A651]"></div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Brand & About --}}
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="PSCM Logo" class="h-12 w-12 rounded-full bg-white object-contain shadow-sm shrink-0">
                    <div>
                        <span class="block text-2xl font-black text-white leading-none tracking-tight">PSCM</span>
                        <span class="block text-[9px] font-bold text-white tracking-wider uppercase mt-1">PRIME SUPPLY CHAIN MANAGEMENT</span>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-300 leading-relaxed max-w-sm">
                    Fast, reliable and secure logistics solutions you can trust.
                </p>
            </div>

            {{-- Quick links --}}
            <div>
                <h4 class="text-base font-bold text-white mb-4">Quick links</h4>
                <ul class="space-y-2.5 text-sm text-gray-300">
                    <li><a href="{{ route('services') }}" class="hover:text-white transition-colors">Services</a></li>
                    <li><a href="{{ route('shipments.track') }}" class="hover:text-white transition-colors">Track shipment</a></li>
                    <li><a href="{{ route('pricing') }}" class="hover:text-white transition-colors">Pricing</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About us</a></li>
                </ul>
            </div>

            {{-- Services --}}
            <div>
                <h4 class="text-base font-bold text-white mb-4">Services</h4>
                <ul class="space-y-2.5 text-sm text-gray-300">
                    <li><a href="{{ route('services') }}#dispatch" class="hover:text-white transition-colors">Dispatch delivery</a></li>
                    <li><a href="{{ route('services') }}#cargo" class="hover:text-white transition-colors">Cargo &amp; haulage</a></li>
                    <li><a href="{{ route('services') }}#business" class="hover:text-white transition-colors">Business logistics</a></li>
                    <li><a href="{{ route('rider-application.create') }}" class="hover:text-white transition-colors">Become a rider</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-base font-bold text-white mb-4">Contact</h4>
                <ul class="space-y-2.5 text-sm text-gray-300">
                    <li>08065888880</li>
                    <li>08157289366</li>
                    <li>C8/C9 Gidan Halima, Zaria Road, Kano</li>
                    <li>info@pscmlogistics.com</li>
                    <li><a href="{{ route('contact') }}" class="hover:text-amber-300 transition-colors">Send us a message</a></li>
                </ul>
            </div>
        </div>

        {{-- Bottom Copyright Bar --}}
        <div class="mt-12 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400">
            <p>&copy; {{ date('Y') }} PSCM Logistics. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login Portal</a>
            </div>
        </div>
    </div>
</footer>
