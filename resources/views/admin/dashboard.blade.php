@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mb-6">
        @foreach ([
            ['label' => 'Total Shipments', 'value' => $stats['total_shipments']],
            ['label' => 'Pending', 'value' => $stats['pending']],
            ['label' => 'In Transit', 'value' => $stats['in_transit']],
            ['label' => 'Delivered', 'value' => $stats['delivered']],
        ] as $stat)
            <div class="card">
                <p class="text-2xl font-extrabold text-primary">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mb-6">
        <div class="card">
            <p class="text-2xl font-extrabold text-secondary">&#8358;{{ number_format($stats['revenue'], 0) }}</p>
            <p class="mt-1 text-xs text-gray-500">Total Revenue (Paid)</p>
        </div>
        <div class="card">
            <p class="text-2xl font-extrabold text-primary">{{ $stats['active_riders'] }}</p>
            <p class="mt-1 text-xs text-gray-500">Active Riders</p>
        </div>
        <div class="card">
            <p class="text-2xl font-extrabold text-primary">{{ $stats['new_rider_applications'] }}</p>
            <p class="mt-1 text-xs text-gray-500">New Rider Applications</p>
        </div>
        <div class="card">
            <p class="text-2xl font-extrabold text-primary">{{ $stats['unread_messages'] }}</p>
            <p class="mt-1 text-xs text-gray-500">Unread Messages</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <div class="card lg:col-span-2">
            <h3 class="font-bold text-gray-900 mb-4">Shipments (Last 14 Days)</h3>
            <canvas id="shipmentsChart" height="110"></canvas>
        </div>
        <div class="card">
            <h3 class="font-bold text-gray-900 mb-4">Status Breakdown</h3>
            <canvas id="statusChart" height="180"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">Recent Shipments</h3>
            <a href="{{ route('admin.shipments.index') }}" class="text-sm font-semibold text-primary hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="py-2 pr-4">Waybill</th>
                        <th class="py-2 pr-4">Sender</th>
                        <th class="py-2 pr-4">Receiver</th>
                        <th class="py-2 pr-4">Rider</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($recentShipments as $shipment)
                        <tr>
                            <td class="py-3 pr-4 font-semibold text-gray-900">{{ $shipment->waybill_number }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $shipment->sender_name }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $shipment->receiver_name }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $shipment->rider->name ?? '—' }}</td>
                            <td class="py-3 pr-4"><span class="badge {{ $shipment->statusBadgeClass() }}">{{ $shipment->statusLabel() }}</span></td>
                            <td class="py-3"><a href="{{ route('admin.shipments.show', $shipment) }}" class="text-primary font-semibold hover:underline">Manage</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-8 text-center text-gray-400">No shipments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const shipmentDates = @json($shipmentsPerDay->pluck('date'));
    const shipmentTotals = @json($shipmentsPerDay->pluck('total'));

    new Chart(document.getElementById('shipmentsChart'), {
        type: 'line',
        data: {
            labels: shipmentDates,
            datasets: [{
                label: 'Shipments',
                data: shipmentTotals,
                borderColor: '#0057D9',
                backgroundColor: 'rgba(0,87,217,0.1)',
                tension: 0.3,
                fill: true,
            }],
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } },
    });

    const statusLabels = @json($statusBreakdown->keys());
    const statusValues = @json($statusBreakdown->values());

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusValues,
                backgroundColor: ['#9CA3AF', '#0057D9', '#3385ff', '#66a3ff', '#00A651', '#EF4444'],
            }],
        },
        options: { plugins: { legend: { position: 'bottom' } } },
    });
</script>
@endpush
