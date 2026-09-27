@extends('layouts.customer')

@section('title', $shipment->waybill_number)

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900">{{ $shipment->waybill_number }}</h2>
        <span class="badge {{ $shipment->statusBadgeClass() }}">{{ $shipment->statusLabel() }}</span>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <h3 class="font-bold text-gray-900">Tracking Timeline</h3>
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
                <img src="{{ route('shipments.qr', $shipment) }}" alt="QR Code" class="mx-auto h-36 w-36">
            </div>
            <div class="card space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Package</span><span class="font-semibold">{{ $shipment->package_type }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Weight</span><span class="font-semibold">{{ $shipment->weight_kg }} kg</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Amount</span><span class="font-semibold">&#8358;{{ number_format($shipment->amount, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Payment</span><span class="badge {{ $shipment->payment_status === 'paid' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($shipment->payment_status) }}</span></div>
                @if ($shipment->rider)
                    <div class="flex justify-between"><span class="text-gray-500">Rider</span><span class="font-semibold">{{ $shipment->rider->name }}</span></div>
                @endif
            </div>
            <div class="space-y-3">
                @if ($shipment->payment_status === 'unpaid')
                    <a href="{{ route('payments.pay', $shipment) }}" class="btn-secondary w-full">Pay Online</a>
                @endif
                <a href="{{ route('shipments.invoice', $shipment) }}" class="btn-outline-dark w-full">Download Invoice</a>
            </div>
        </div>
    </div>

@endsection
