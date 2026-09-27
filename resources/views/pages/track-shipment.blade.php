@extends('layouts.site')

@section('title', 'Track Shipment - PSCM')

@section('content')

    <section class="bg-primary-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-secondary-400">Track Shipment</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white">Where's My Package?</h1>
            <p class="mt-4 max-w-2xl text-gray-300">Enter your waybill number to get real-time status of your shipment.</p>
        </div>
    </section>

    <section class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="card">
            <form method="POST" action="{{ route('shipments.track.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="waybill_number" class="label">Waybill Number</label>
                    <input id="waybill_number" name="waybill_number" class="input" placeholder="e.g. PSCM2608ABCDE" value="{{ old('waybill_number') }}" required autofocus>
                    <x-input-error :messages="$errors->get('waybill_number')" class="mt-2" />
                </div>
                <button type="submit" class="btn-primary w-full">Track Now</button>
            </form>
        </div>
        <p class="mt-4 text-center text-sm text-gray-500">
            Don't have a waybill yet? <a href="{{ route('shipments.create') }}" class="font-semibold text-primary hover:underline">Request a pickup</a>
        </p>
    </section>

@endsection
