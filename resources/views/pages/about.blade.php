@extends('layouts.site')

@section('title', 'About Us - PSCM')

@section('content')

    <section class="bg-primary-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-secondary-400">About PSCM</p>
            <h1 class="mt-2 max-w-2xl text-4xl font-extrabold text-white">Delivering Excellence, Building Trust</h1>
            <p class="mt-4 max-w-2xl text-gray-300">
                PSCM (Prime Supply Chain Management) is a trusted logistics company committed to providing fast, reliable and secure logistics solutions across Kano State and beyond.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">
            <div class="overflow-hidden rounded-xl">
                <img src="{{ asset('images/logistics-operations.jpg') }}" alt="PSCM logistics operations" class="h-72 w-full object-cover">
            </div>
            <div class="space-y-6">
                <div class="card">
                    <h2 class="text-xl font-bold text-gray-900">Our Mission</h2>
                    <p class="mt-3 text-gray-600">To deliver every package with speed, care and integrity — helping businesses and individuals move goods across Kano State and beyond with total confidence.</p>
                </div>
                <div class="card">
                    <h2 class="text-xl font-bold text-gray-900">Our Vision</h2>
                    <p class="mt-3 text-gray-600">To become Northern Nigeria's most trusted logistics and dispatch partner, powering commerce through reliable, technology-driven supply chain solutions.</p>
                </div>
            </div>
        </div>

        <div class="mt-16 text-center">
            <h2 class="section-title">Why Choose PSCM?</h2>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['icon' => '⚡', 'title' => 'Speed', 'desc' => 'Same-day pickups and prompt deliveries.'],
                ['icon' => '🔒', 'title' => 'Security', 'desc' => 'Every package handled with the utmost care.'],
                ['icon' => '📊', 'title' => 'Transparency', 'desc' => 'Real-time tracking from pickup to delivery.'],
                ['icon' => '🤝', 'title' => 'Reliability', 'desc' => 'Trusted by 1000+ happy customers.'],
            ] as $value)
                <div class="card text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-secondary-50 text-2xl">{{ $value['icon'] }}</div>
                    <h3 class="mt-4 font-bold text-gray-900">{{ $value['title'] }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

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

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">
            <div>
                <h2 class="section-title">Every Delivery, Right on Time</h2>
                <p class="mt-4 text-gray-600">From pickup to final delivery, our riders and dispatch network are coordinated to keep every shipment moving on schedule — no missed windows, no guesswork.</p>
            </div>
            <div class="overflow-hidden rounded-xl">
                <img src="{{ asset('images/on-time-delivery.jpg') }}" alt="PSCM on-time delivery network" class="h-72 w-full object-cover">
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
        <h2 class="section-title">Want to be part of our journey?</h2>
        <p class="mt-3 text-gray-500">Whether as a customer or a rider, PSCM has a place for you.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <a href="{{ route('shipments.create') }}" class="btn-secondary">Request a Pickup</a>
            <a href="{{ route('rider-application.create') }}" class="btn-outline-dark">Become a Rider</a>
        </div>
    </section>

@endsection
