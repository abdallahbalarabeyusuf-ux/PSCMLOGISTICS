@extends('layouts.site')

@section('title', 'Pickup Confirmed - PSCM')

@section('content')

    <section class="mx-auto max-w-2xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-secondary-50 text-3xl">✅</div>
        <h1 class="mt-6 text-3xl font-extrabold text-gray-900">Pickup Request Received!</h1>
        <p class="mt-3 text-gray-500">Your waybill number is</p>
        <p class="mt-1 text-2xl font-extrabold text-primary">{{ $shipment->waybill_number }}</p>
        <p class="mt-4 text-sm text-gray-500">We've sent a confirmation SMS to {{ $shipment->sender_phone }}. Save your waybill number to track this shipment anytime.</p>

        <div class="mt-8 card mx-auto max-w-md text-left">
            <div class="flex justify-between text-sm py-1"><span class="text-gray-500">Package</span><span class="font-semibold">{{ $shipment->package_type }} ({{ $shipment->weight_kg }} kg)</span></div>
            <div class="flex justify-between text-sm py-1"><span class="text-gray-500">Amount</span><span class="font-semibold">&#8358;{{ number_format($shipment->amount, 2) }}</span></div>
            <div class="flex justify-between text-sm py-1"><span class="text-gray-500">Payment</span><span class="font-semibold">{{ $shipment->payment_method === 'online' ? 'Pay Online' : 'Pay on Delivery' }}</span></div>
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-4">
            @if ($shipment->payment_method === 'online' && $shipment->payment_status === 'unpaid')
                <a href="{{ route('payments.pay', $shipment) }}" class="btn-secondary">Pay Now</a>
            @endif
            <a href="{{ route('shipments.show', $shipment) }}" class="btn-primary">Track This Shipment</a>
            <a href="https://wa.me/?text={{ rawurlencode("My PSCM waybill number is {$shipment->waybill_number}. Track it here: " . route('shipments.show', $shipment)) }}"
               target="_blank" rel="noopener" class="btn-outline-dark">Send My Waybill via WhatsApp</a>
        </div>
    </section>

@endsection
