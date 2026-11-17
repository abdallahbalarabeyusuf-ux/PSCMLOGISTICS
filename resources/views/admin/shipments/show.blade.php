@extends('layouts.admin')

@section('title', $shipment->waybill_number)

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900">{{ $shipment->waybill_number }}</h2>
        <span class="badge {{ $shipment->statusBadgeClass() }}">{{ $shipment->statusLabel() }}</span>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">

            <div class="card">
                <h3 class="font-bold text-gray-900 mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.shipments.updateStatus', $shipment) }}" class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    @csrf
                    <div>
                        <label class="label">Status</label>
                        <select name="status" class="input" required>
                            @foreach (['pending' => 'Pending', 'picked_up' => 'Picked Up', 'in_transit' => 'In Transit', 'out_for_delivery' => 'Out for Delivery', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'] as $value => $label)
                                <option value="{{ $value }}" @selected($shipment->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Location (optional)</label>
                        <input name="location" class="input" placeholder="e.g. Sabon Gari Market">
                    </div>
                    <div>
                        <label class="label">Note (optional)</label>
                        <input name="note" class="input">
                    </div>
                    <div class="sm:col-span-3">
                        <button type="submit" class="btn-primary">Update &amp; Notify Customer</button>
                    </div>
                </form>
            </div>

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
                    @if ($shipment->user)
                        <p class="mt-2 text-xs text-gray-400">Registered customer: {{ $shipment->user->email }}</p>
                    @endif
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
                <a href="{{ route('shipments.invoice', $shipment) }}" class="btn-outline-dark w-full mt-4">Download Invoice</a>
            </div>

            <div class="card">
                <h3 class="font-bold text-gray-900 mb-4">Assign Rider &amp; Payment</h3>
                <form method="POST" action="{{ route('admin.shipments.update', $shipment) }}" class="space-y-4" x-data="shipmentPricingForm(@json(old('distance_km', $shipment->distance_km)), @json(old('amount', (float) $shipment->amount > 0 ? $shipment->amount : null)))">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="label">Rider</label>
                        <select name="rider_id" class="input">
                            <option value="">Unassigned</option>
                            @foreach ($riders as $rider)
                                <option value="{{ $rider->id }}" @selected($shipment->rider_id === $rider->id)>{{ $rider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Payment Status</label>
                        <select name="payment_status" class="input">
                            <option value="unpaid" @selected($shipment->payment_status === 'unpaid')>Unpaid</option>
                            <option value="paid" @selected($shipment->payment_status === 'paid')>Paid</option>
                        </select>
                    </div>
                    <div>
                        <label for="distance_km" class="label">Trip Distance (km)</label>
                        <input id="distance_km" type="number" step="0.1" min="0.1" max="10000" name="distance_km" value="{{ old('distance_km', $shipment->distance_km) }}" class="input" x-model.number="distance" @input="updateAmount()">
                    </div>
                    <div>
                        <label for="amount" class="label">Estimated Price (&#8358;)</label>
                        <input id="amount" type="number" step="0.01" min="0.01" name="amount" value="{{ old('amount', (float) $shipment->amount > 0 ? $shipment->amount : '') }}" class="input" x-model="amount">
                        <p class="text-xs text-gray-500">Suggested at &#8358;{{ number_format(config('pricing.base_fee'), 2) }} base + &#8358;{{ number_format(config('pricing.rate_per_km'), 2) }}/km. Review or adjust before saving.</p>
                    </div>
                    <button type="submit" class="btn-primary w-full">Save Changes</button>
                </form>
            </div>

            <form method="POST" action="{{ route('admin.shipments.destroy', $shipment) }}" onsubmit="return confirm('Delete this shipment permanently?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn w-full border border-red-200 text-red-600 hover:bg-red-50">Delete Shipment</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function shipmentPricingForm(distance, amount) {
        return {
            distance: distance || '',
            amount: amount || '',
            baseFee: @json(config('pricing.base_fee')),
            ratePerKm: @json(config('pricing.rate_per_km')),
            init() {
                if (Number(this.distance) > 0 && !this.amount) {
                    this.updateAmount();
                }
            },
            updateAmount() {
                const distanceKm = Number(this.distance);
                this.amount = distanceKm > 0
                    ? (this.baseFee + this.ratePerKm * distanceKm).toFixed(2)
                    : '';
            },
        };
    }
</script>
@endpush
