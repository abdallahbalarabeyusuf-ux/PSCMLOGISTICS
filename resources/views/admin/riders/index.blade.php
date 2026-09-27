@extends('layouts.admin')

@section('title', 'Riders')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900">All Riders</h2>
        <a href="{{ route('admin.riders.create') }}" class="btn-secondary">+ Add Rider</a>
    </div>

    <div class="card mb-6">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-gray-900">Live Rider Map</h3>
            <span class="text-xs text-gray-400" id="riders-map-updated"></span>
        </div>
        <div id="riders-map" class="mt-4 h-72 w-full rounded-lg bg-gray-100"></div>
    </div>

    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="py-2 pr-4">Name</th>
                        <th class="py-2 pr-4">Phone</th>
                        <th class="py-2 pr-4">Vehicle</th>
                        <th class="py-2 pr-4">Shipments</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($riders as $rider)
                        <tr>
                            <td class="py-3 pr-4 font-semibold text-gray-900">{{ $rider->name }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $rider->phone }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ ucfirst($rider->vehicle_type) }} @if($rider->plate_number) ({{ $rider->plate_number }}) @endif</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $rider->shipments_count }}</td>
                            <td class="py-3 pr-4"><span class="badge {{ $rider->status === 'active' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($rider->status) }}</span></td>
                            <td class="py-3 flex gap-3">
                                <form method="POST" action="{{ route('admin.riders.impersonate', $rider) }}">
                                    @csrf
                                    <button type="submit" class="text-primary font-semibold hover:underline">View Dashboard</button>
                                </form>
                                <a href="{{ route('admin.riders.edit', $rider) }}" class="text-primary font-semibold hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.riders.destroy', $rider) }}" onsubmit="return confirm('Remove this rider?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold hover:underline">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-8 text-center text-gray-400">No riders added yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $riders->links() }}</div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const ridersMap = L.map('riders-map').setView([12.0022, 8.5920], 12); // Kano, Nigeria
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(ridersMap);

    let riderMarkers = {};

    async function pollRiderLocations() {
        try {
            const response = await fetch(@json(route('admin.riders.locations')));
            const riders = await response.json();

            const seenIds = new Set();

            riders.forEach((rider) => {
                seenIds.add(rider.id);
                const latLng = [rider.lat, rider.lng];

                if (!riderMarkers[rider.id]) {
                    riderMarkers[rider.id] = L.marker(latLng).addTo(ridersMap);
                } else {
                    riderMarkers[rider.id].setLatLng(latLng);
                }

                riderMarkers[rider.id].bindPopup(`<strong>${rider.name}</strong><br>${rider.vehicle_type}<br>Updated ${rider.updated_at}`);
            });

            Object.keys(riderMarkers).forEach((id) => {
                if (!seenIds.has(Number(id))) {
                    ridersMap.removeLayer(riderMarkers[id]);
                    delete riderMarkers[id];
                }
            });

            document.getElementById('riders-map-updated').textContent = riders.length + ' rider(s) online';
        } catch (e) {
            document.getElementById('riders-map-updated').textContent = 'Unable to load live locations.';
        }
    }

    pollRiderLocations();
    setInterval(pollRiderLocations, 10000);
</script>
@endpush
