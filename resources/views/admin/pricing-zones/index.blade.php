@extends('layouts.admin')

@section('title', 'Pricing Zones')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900">Pricing Zones</h2>
        <a href="{{ route('admin.pricing-zones.create') }}" class="btn-secondary">+ Add Zone</a>
    </div>

    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="py-2 pr-4">Code</th>
                        <th class="py-2 pr-4">Name</th>
                        <th class="py-2 pr-4">Base Fee</th>
                        <th class="py-2 pr-4">Rate / kg</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($zones as $zone)
                        <tr>
                            <td class="py-3 pr-4"><span class="badge-blue">{{ $zone->code }}</span></td>
                            <td class="py-3 pr-4 font-semibold text-gray-900">{{ $zone->name }}</td>
                            <td class="py-3 pr-4 text-gray-600">&#8358;{{ number_format($zone->base_fee, 2) }}</td>
                            <td class="py-3 pr-4 text-gray-600">&#8358;{{ number_format($zone->rate_per_kg, 2) }}</td>
                            <td class="py-3 flex gap-3">
                                <a href="{{ route('admin.pricing-zones.edit', $zone) }}" class="text-primary font-semibold hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.pricing-zones.destroy', $zone) }}" onsubmit="return confirm('Delete this pricing zone?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-8 text-center text-gray-400">No pricing zones yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
