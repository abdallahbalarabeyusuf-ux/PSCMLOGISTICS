@extends('layouts.site')

@section('title', 'PSCM - Delivering Trust. Every Time.')

@section('content')

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-primary-900">
        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
            <div>
                <h1 class="text-4xl font-extrabold leading-tight text-white sm:text-5xl">
                    Delivering Trust.<br>
                    <span class="text-secondary-400">Every Time.</span>
                </h1>
                <p class="mt-5 max-w-lg text-lg text-gray-300">
                    Fast, reliable and secure logistics &amp; dispatch services across Kano State and beyond.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('shipments.create') }}" class="btn-secondary">Request a Pickup &rarr;</a>
                    <a href="{{ route('shipments.track') }}" class="btn-outline">Track Shipment</a>
                </div>

                <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    @foreach ([
                        ['icon' => '🚚', 'title' => 'Fast Delivery', 'desc' => 'Same-day delivery within Kano'],
                        ['icon' => '🛡️', 'title' => 'Secure Handling', 'desc' => 'Your goods are safe with us'],
                        ['icon' => '📍', 'title' => 'Live Tracking', 'desc' => 'Track your shipment in real time'],
                        ['icon' => '🎧', 'title' => '24/7 Support', 'desc' => "We're here to help you anytime"],
                    ] as $feature)
                        <div class="rounded-lg bg-white/5 p-3 backdrop-blur">
                            <div class="text-xl">{{ $feature['icon'] }}</div>
                            <div class="mt-1 text-sm font-semibold text-white">{{ $feature['title'] }}</div>
                            <div class="text-xs text-gray-400">{{ $feature['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-secondary-500/20 to-primary-500/20 p-3">
                    <img src="{{ asset('images/port-crane-sunset.jpg') }}"
                         alt="PSCM logistics network in motion"
                         class="h-full w-full rounded-xl object-cover border border-white/10">
                </div>
                <div class="absolute -bottom-4 -left-4 rounded-xl bg-white px-5 py-3 shadow-lg">
                    <p class="text-xs text-gray-500">Live Waybill</p>
                    <p class="text-sm font-bold text-primary">PSCM2608XXXXX</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Global-Ready Network --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="section-title">Built for Kano State, Ready for Anywhere</h2>
            <p class="mt-3 text-gray-500">Local dispatch speed, backed by a network that scales with your business.</p>
        </div>
        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="overflow-hidden rounded-xl">
                <img src="{{ asset('images/network-map.jpg') }}" alt="PSCM logistics route network" class="h-64 w-full object-cover">
            </div>
            <div class="overflow-hidden rounded-xl">
                <img src="{{ asset('images/plane-cargo-ship.jpg') }}" alt="PSCM multi-modal logistics" class="h-64 w-full object-cover">
            </div>
        </div>
    </section>

    {{-- Logistics Solutions --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="section-title">Our Logistics Solutions</h2>
            <p class="mt-3 text-gray-500">We provide end-to-end logistics solutions tailored to your needs.</p>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['icon' => '🏍️', 'title' => 'Dispatch Delivery', 'desc' => 'Quick and reliable dispatch services within Kano State.', 'anchor' => 'dispatch'],
                ['icon' => '🚛', 'title' => 'Cargo & Haulage', 'desc' => 'Safe transportation of goods nationwide by road.', 'anchor' => 'cargo'],
                ['icon' => '🏢', 'title' => 'Business Logistics', 'desc' => 'Daily logistics support for businesses of all sizes.', 'anchor' => 'business'],
                ['icon' => '🏭', 'title' => 'Warehousing & Distribution', 'desc' => 'Secure storage and efficient distribution solutions.', 'anchor' => 'warehousing'],
            ] as $service)
                <div class="card">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary-50 text-2xl">{{ $service['icon'] }}</div>
                    <h3 class="mt-4 text-lg font-bold text-gray-900">{{ $service['title'] }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ $service['desc'] }}</p>
                    <a href="{{ route('services') }}#{{ $service['anchor'] }}" class="mt-4 inline-block text-sm font-semibold text-primary hover:underline">Learn More &rarr;</a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Stats --}}
    <section class="bg-primary-900">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-12 sm:px-6 lg:grid-cols-4 lg:px-8">
            @foreach ([
                ['value' => '1000+', 'label' => 'Happy Customers'],
                ['value' => '5000+', 'label' => 'Successful Deliveries'],
                ['value' => '20+', 'label' => 'Dedicated Riders'],
                ['value' => '98%', 'label' => 'On-time Delivery'],
            ] as $stat)
                <div class="text-center">
                    <div class="text-3xl font-extrabold text-white sm:text-4xl">{{ $stat['value'] }}</div>
                    <div class="mt-1 text-sm text-gray-300">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- How It Works --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="section-title">How It Works</h2>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['step' => '01', 'title' => 'Book Online', 'desc' => 'Enter your pickup details in minutes.'],
                ['step' => '02', 'title' => 'We Pick Up', 'desc' => 'Our rider picks up your package.'],
                ['step' => '03', 'title' => 'We Deliver', 'desc' => 'We deliver safely to the destination.'],
                ['step' => '04', 'title' => 'You Receive', 'desc' => 'You get confirmation and peace of mind.'],
            ] as $item)
                <div class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-secondary text-lg font-extrabold text-white">{{ $item['step'] }}</div>
                    <h3 class="mt-4 font-bold text-gray-900">{{ $item['title'] }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-secondary">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-4 py-12 text-center sm:px-6 lg:flex-row lg:text-left lg:px-8">
            <div>
                <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Ready to simplify your logistics?</h2>
                <p class="mt-2 text-secondary-50">Join hundreds of businesses and individuals who trust PSCM.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('shipments.create') }}" class="btn bg-white text-secondary-700 hover:bg-gray-100">Request a Pickup</a>
                <a href="{{ route('contact') }}" class="btn-outline">Contact Us</a>
            </div>
        </div>
    </section>

@endsection
