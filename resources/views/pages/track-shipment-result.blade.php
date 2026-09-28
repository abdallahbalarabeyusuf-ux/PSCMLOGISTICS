@extends('layouts.site')

@section('title', 'Shipment ' . $shipment->waybill_number . ' - PSCM')

@section('content')

    <section class="bg-primary-900">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-secondary-400">Shipment Status</p>
            <div class="mt-2 flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-3xl font-extrabold text-white">{{ $shipment->waybill_number }}</h1>
                <span class="badge {{ $shipment->statusBadgeClass() }}">{{ $shipment->statusLabel() }}</span>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">

                <div class="card">
                    <h2 class="font-bold text-gray-900">Tracking Timeline</h2>
                    <div class="mt-4">
                        @include('partials.shipment-timeline')
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="card">
                        <h3 class="text-sm font-bold uppercase text-gray-500">Sender</h3>
                        <p class="mt-2 font-semibold text-gray-900">{{ $shipment->sender_name }}</p>
                        <p class="text-sm text-gray-500">{{ $shipment->sender_phone }}</p>
                        <p class="text-sm text-gray-500">{{ $shipment->pickup_address }}</p>
                    </div>
                    <div class="card">
                        <h3 class="text-sm font-bold uppercase text-gray-500">Receiver</h3>
                        <p class="mt-2 font-semibold text-gray-900">{{ $shipment->receiver_name }}</p>
                        <p class="text-sm text-gray-500">{{ $shipment->receiver_phone }}</p>
                        <p class="text-sm text-gray-500">{{ $shipment->delivery_address }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card text-center">
                    <img src="{{ route('shipments.qr', $shipment) }}" alt="Shipment QR Code" class="mx-auto h-40 w-40">
                    <p class="mt-2 text-xs text-gray-500">Scan to view shipment status</p>
                </div>

                <div class="card space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Package</span><span class="font-semibold">{{ $shipment->package_type }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Weight</span><span class="font-semibold">{{ $shipment->weight_kg }} kg</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Amount</span><span class="font-semibold">&#8358;{{ number_format($shipment->amount, 2) }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Payment</span>
                        <span class="badge {{ $shipment->payment_status === 'paid' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($shipment->payment_status) }}</span>
                    </div>
                    @if ($shipment->rider)
                        <div class="flex justify-between"><span class="text-gray-500">Rider</span><span class="font-semibold">{{ $shipment->rider->name }}</span></div>
                    @endif
                </div>

                <div class="space-y-3">
                    @if ($shipment->payment_status === 'unpaid')
                        <a href="{{ route('payments.pay', $shipment) }}" class="btn-secondary w-full">Pay Online</a>
                    @endif
                    <a href="{{ route('shipments.invoice', $shipment) }}" class="btn-outline-dark w-full">Download Invoice</a>
                    <a href="https://wa.me/{{ config('company.whatsapp_number') }}?text={{ rawurlencode("Hi PSCM, I have a question about shipment {$shipment->waybill_number}.") }}"
                       target="_blank" rel="noopener" class="btn-outline-dark w-full">Ask About This Shipment on WhatsApp</a>
                </div>
            </div>
        </div>
    </section>

@endsection


