@php
    $steps = ['pending' => 'Pending Pickup', 'picked_up' => 'Picked Up', 'in_transit' => 'In Transit', 'out_for_delivery' => 'Out for Delivery', 'delivered' => 'Delivered'];
    $currentIndex = array_search($shipment->status, array_keys($steps));
@endphp

@if ($shipment->status === 'cancelled')
    <div class="rounded-lg bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-700">This shipment has been cancelled.</div>
@endif

<div class="mt-2">
    @forelse ($shipment->trackingUpdates as $update)
        <div class="timeline-item is-complete">
            <span class="timeline-dot"></span>
            <p class="font-semibold text-gray-900">{{ \Illuminate\Support\Str::headline($update->status) }}</p>
            @if ($update->location)
                <p class="text-sm text-gray-500">📍 {{ $update->location }}</p>
            @endif
            @if ($update->note)
                <p class="text-sm text-gray-500">{{ $update->note }}</p>
            @endif
            <p class="text-xs text-gray-400">{{ $update->created_at->format('d M Y, h:ia') }}</p>
        </div>
    @empty
        <p class="text-sm text-gray-500">No tracking updates yet.</p>
    @endforelse
</div>
