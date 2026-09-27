@extends('layouts.customer')

@section('title', 'My Dashboard')

@section('content')

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mb-8">
        @foreach ([
            ['label' => 'Total Shipments', 'value' => $stats['total'], 'color' => 'text-primary'],
            ['label' => 'In Transit', 'value' => $stats['in_transit'], 'color' => 'text-secondary'],
            ['label' => 'Delivered', 'value' => $stats['delivered'], 'color' => 'text-secondary'],
            ['label' => 'Pending', 'value' => $stats['pending'], 'color' => 'text-gray-500'],
        ] as $stat)
            <div class="card">
                <p class="text-2xl font-extrabold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-gray-900">My Shipments</h2>
            <a href="{{ route('shipments.create') }}" class="btn-secondary text-xs px-4 py-2">+ New Pickup</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="py-2 pr-4">Waybill</th>
                        <th class="py-2 pr-4">Receiver</th>
                        <th class="py-2 pr-4">Amount</th>
                        <th class="py-2 pr-4">Payment</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2 pr-4">Date</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($shipments as $shipment)
                        <tr>
                            <td class="py-3 pr-4 font-semibold text-gray-900">{{ $shipment->waybill_number }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $shipment->receiver_name }}</td>
                            <td class="py-3 pr-4 text-gray-600">&#8358;{{ number_format($shipment->amount, 2) }}</td>
                            <td class="py-3 pr-4"><span class="badge {{ $shipment->payment_status === 'paid' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($shipment->payment_status) }}</span></td>
                            <td class="py-3 pr-4"><span class="badge {{ $shipment->statusBadgeClass() }}">{{ $shipment->statusLabel() }}</span></td>
                            <td class="py-3 pr-4 text-gray-500">{{ $shipment->created_at->format('d M Y') }}</td>
                            <td class="py-3">
                                <a href="{{ route('customer.shipments.show', $shipment) }}" class="text-primary font-semibold hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400">You haven't booked any shipments yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $shipments->links() }}</div>
    </div>

@endsection
