@extends('layouts.site')

@section('title', 'Our Services - PSCM')

@section('content')

    <section class="bg-primary-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-secondary-400">Services</p>
            <h1 class="mt-2 max-w-2xl text-4xl font-extrabold text-white">Logistics Solutions Built for Kano State & Beyond</h1>
            <p class="mt-4 max-w-2xl text-gray-300">From dispatch delivery to full-scale warehousing, PSCM covers every stage of your supply chain.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl space-y-16 px-4 py-16 sm:px-6 lg:px-8">

        <div id="dispatch" class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">
            <div>
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary-50 text-3xl">🏍️</div>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Dispatch Delivery</h2>
                <p class="mt-3 text-gray-600">Quick and reliable dispatch services within Kano State — perfect for documents, small parcels and urgent errands.</p>
                <ul class="mt-4 space-y-2 text-sm text-gray-600">
                    <li>✔ Same-day delivery within Kano metro</li>
                    <li>✔ Real-time rider tracking</li>
                    <li>✔ Affordable per-kg pricing</li>
                </ul>
                <a href="{{ route('shipments.create') }}" class="btn-primary mt-6 inline-flex">Request Pickup</a>
            </div>
            <div class="h-80 overflow-hidden rounded-xl">
                <img src="{{ asset('images/dispatch-globe.jpg') }}" alt="PSCM dispatch delivery" class="h-full w-full object-cover object-top">
            </div>
        </div>

        <div id="cargo" class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">
            <div class="h-80 overflow-hidden rounded-xl lg:order-1">
                <img src="{{ asset('images/cargo-haulage.jpg') }}" alt="PSCM cargo and haulage" class="h-full w-full object-cover object-top">
            </div>
            <div class="lg:order-2">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary-50 text-3xl">🚛</div>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Cargo &amp; Haulage</h2>
                <p class="mt-3 text-gray-600">Safe transportation of goods nationwide by road, for bulk shipments, market goods and inter-state cargo.</p>
                <ul class="mt-4 space-y-2 text-sm text-gray-600">
                    <li>✔ Nationwide coverage</li>
                    <li>✔ Insured cargo handling</li>
                    <li>✔ Flexible scheduling</li>
                </ul>
                <a href="{{ route('shipments.create') }}" class="btn-primary mt-6 inline-flex">Request Pickup</a>
            </div>
        </div>

        <div id="business" class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">
            <div>
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary-50 text-3xl">🏢</div>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Business Logistics</h2>
                <p class="mt-3 text-gray-600">Daily logistics support for businesses of all sizes — from e-commerce order fulfillment to recurring B2B deliveries.</p>
                <ul class="mt-4 space-y-2 text-sm text-gray-600">
                    <li>✔ Dedicated account support</li>
                    <li>✔ Bulk shipment discounts</li>
                    <li>✔ Invoicing &amp; reporting</li>
                </ul>
                <a href="{{ route('contact') }}" class="btn-primary mt-6 inline-flex">Talk to Sales</a>
            </div>
            <div class="h-80 overflow-hidden rounded-xl">
                <img src="{{ asset('images/business-logistics-map.jpg') }}" alt="PSCM business logistics network" class="h-full w-full object-cover object-top">
            </div>
        </div>

        <div id="warehousing" class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">
            <div class="h-80 overflow-hidden rounded-xl lg:order-1">
                <img src="{{ asset('images/warehouse-operations.jpg') }}" alt="PSCM warehousing and distribution" class="h-full w-full object-cover object-top">
            </div>
            <div class="lg:order-2">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary-50 text-3xl">🏭</div>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Warehousing &amp; Distribution</h2>
                <p class="mt-3 text-gray-600">Secure storage and efficient distribution solutions for businesses that need reliable inventory management.</p>
                <ul class="mt-4 space-y-2 text-sm text-gray-600">
                    <li>✔ Secure, monitored facilities</li>
                    <li>✔ Inventory management</li>
                    <li>✔ Pick, pack &amp; distribute</li>
                </ul>
                <a href="{{ route('contact') }}" class="btn-primary mt-6 inline-flex">Talk to Sales</a>
            </div>
        </div>

    </section>

@endsection
