@extends('layouts.rider')

@section('title', 'My Dashboard')

@section('content')

    <div class="grid grid-cols-2 gap-3 mb-6">
        @foreach ([
            ['label' => 'Active Deliveries', 'value' => $stats['active'], 'color' => 'text-primary'],
            ['label' => 'Delivered (7 days)', 'value' => $stats['delivered_this_week'], 'color' => 'text-secondary'],
            ['label' => 'Total Delivered', 'value' => $stats['delivered'], 'color' => 'text-secondary'],
            ['label' => 'Total Assigned', 'value' => $stats['total'], 'color' => 'text-gray-700'],
        ] as $stat)
            <div class="card p-4">
                <p class="text-xl font-extrabold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div x-data="locationSharing()" x-init="init()" class="card mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-gray-900">Location Sharing</h2>
                <p class="mt-1 text-xs text-gray-500" x-text="statusText"></p>
            </div>
            <button
                @click="toggle()"
                :class="sharing ? 'bg-secondary' : 'bg-gray-300'"
                class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors">
                <span :class="sharing ? 'translate-x-7' : 'translate-x-1'" class="inline-block h-6 w-6 transform rounded-full bg-white transition-transform"></span>
            </button>
        </div>
        <p class="mt-3 text-xs text-gray-400">Keep this page open in your browser while you're on a delivery so customers and the office can see your live location.</p>
    </div>

    <div class="card">
        <h2 class="font-bold text-gray-900 mb-4">My Active Deliveries</h2>
        <div class="space-y-3">
            @forelse ($shipments as $shipment)
                <div class="rounded-lg border border-gray-100 p-4">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-900">{{ $shipment->waybill_number }}</span>
                        <span class="badge {{ $shipment->statusBadgeClass() }}">{{ $shipment->statusLabel() }}</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">To: {{ $shipment->receiver_name }} ({{ $shipment->receiver_phone }})</p>
                    <p class="text-sm text-gray-500">{{ $shipment->delivery_address }}</p>
                </div>
            @empty
                <p class="py-6 text-center text-gray-400">No active deliveries assigned to you right now.</p>
            @endforelse
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function locationSharing() {
        return {
            sharing: false,
            watchId: null,
            statusText: 'Location sharing is off.',
            init() {
                this.sharing = localStorage.getItem('pscm_rider_sharing') === '1';
                if (this.sharing) this.start();
            },
            toggle() {
                this.sharing ? this.stop() : this.start();
            },
            start() {
                if (!('geolocation' in navigator)) {
                    this.statusText = 'Geolocation is not supported on this device.';
                    return;
                }
                this.sharing = true;
                localStorage.setItem('pscm_rider_sharing', '1');
                this.statusText = 'Requesting location permission...';
                this.watchId = navigator.geolocation.watchPosition(
                    (position) => this.send(position),
                    (error) => {
                        this.statusText = 'Location error: ' + error.message;
                    },
                    { enableHighAccuracy: true, maximumAge: 10000, timeout: 15000 }
                );
            },
            stop() {
                this.sharing = false;
                localStorage.setItem('pscm_rider_sharing', '0');
                this.statusText = 'Location sharing is off.';
                if (this.watchId !== null) {
                    navigator.geolocation.clearWatch(this.watchId);
                    this.watchId = null;
                }
            },
            async send(position) {
                try {
                    const response = await fetch(@json(route('rider.location')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        }),
                    });
                    if (response.ok) {
                        this.statusText = 'Sharing live location — last updated ' + new Date().toLocaleTimeString();
                    } else {
                        this.statusText = 'Could not update location (please check your connection).';
                    }
                } catch (e) {
                    this.statusText = 'Could not update location (please check your connection).';
                }
            },
        };
    }
</script>
@endpush
