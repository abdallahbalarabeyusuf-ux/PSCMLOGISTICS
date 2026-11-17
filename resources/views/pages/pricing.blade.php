@extends('layouts.site')

@section('title', 'Pricing - PSCM')

@section('content')

    <section class="bg-primary-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-secondary-400">Pricing</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white">Simple, Transparent Pricing</h1>
            <p class="mt-4 max-w-2xl text-gray-300">Estimate your shipment price by trip distance. The final estimate is confirmed by our admin.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">

            <div class="card" id="calculator" x-data="pricingCalculator()">
                <h2 class="text-xl font-bold text-gray-900">Pricing Calculator</h2>
                <div class="mt-6 space-y-4">
                    <div>
                        <label for="calc_distance" class="label">Trip Distance (km)</label>
                        <input id="calc_distance" type="number" min="0.1" max="10000" step="0.1" x-model.number="distance" class="input">
                    </div>
                    <button type="button" @click="calculate()" class="btn-primary w-full" :disabled="loading">
                        <span x-show="!loading">Calculate Price</span>
                        <span x-show="loading" style="display:none">Calculating...</span>
                    </button>

                    <div x-show="amount" x-cloak class="rounded-lg bg-secondary-50 p-4 text-center" style="display:none">
                        <p class="text-sm text-secondary-700">Estimated Price</p>
                        <p class="text-3xl font-extrabold text-secondary-700">&#8358;<span x-text="amount"></span></p>
                        <p class="mt-1 text-xs text-gray-500">Final price is confirmed by an admin.</p>
                    </div>

                    <a href="{{ route('shipments.create') }}" class="btn-secondary w-full">Request Pickup</a>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-900">Distance-Based Pricing</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Base fee &#8358;{{ number_format(config('pricing.base_fee'), 2) }} +
                    &#8358;{{ number_format(config('pricing.rate_per_km'), 2) }} per kilometer.
                </p>
                <div class="mt-6 space-y-4">
                    @forelse ($zones as $z)
                        <div class="card flex items-center justify-between">
                            <p class="font-semibold text-gray-900">{{ $z->name }}</p>
                            <span class="badge-blue">{{ $z->code }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500">Pricing zones are being set up. Please check back soon.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    function pricingCalculator() {
        return {
            distance: null,
            amount: null,
            loading: false,
            async calculate() {
                this.loading = true;
                this.amount = null;
                try {
                    const response = await fetch(@json(route('pricing.calculate')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ distance_km: this.distance }),
                    });
                    const data = await response.json();
                    this.amount = data.amount;
                } catch (e) {
                    this.amount = null;
                } finally {
                    this.loading = false;
                }
            },
        };
    }
</script>
@endpush
