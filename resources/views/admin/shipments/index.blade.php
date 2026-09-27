@extends('layouts.admin')

@section('title', 'Shipments')

@section('content')

    <div class="card mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search waybill, sender or receiver..." class="input flex-1 min-w-[200px]">
            <select name="status" class="input w-auto">
                <option value="">All Statuses</option>
                @foreach (['pending', 'picked_up', 'in_transit', 'out_for_delivery', 'delivered', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ \Illuminate\Support\Str::headline($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary">Filter</button>
        </form>
    </div>

    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="py-2 pr-4">Waybill</th>
                        <th class="py-2 pr-4">Sender</th>
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
                            <td class="py-3 pr-4 text-gray-600">{{ $shipment->sender_name }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $shipment->receiver_name }}</td>
                            <td class="py-3 pr-4 text-gray-600">&#8358;{{ number_format($shipment->amount, 2) }}</td>
                            <td class="py-3 pr-4"><span class="badge {{ $shipment->payment_status === 'paid' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($shipment->payment_status) }}</span></td>
                            <td class="py-3 pr-4"><span class="badge {{ $shipment->statusBadgeClass() }}">{{ $shipment->statusLabel() }}</span></td>
                            <td class="py-3 pr-4 text-gray-500">{{ $shipment->created_at->format('d M Y') }}</td>
                            <td class="py-3"><a href="{{ route('admin.shipments.show', $shipment) }}" class="text-primary font-semibold hover:underline">Manage</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="py-8 text-center text-gray-400">No shipments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $shipments->links() }}</div>
    </div>

@endsection
