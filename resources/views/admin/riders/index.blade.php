@extends('layouts.admin')

@section('title', 'Riders')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900">All Riders</h2>
        <a href="{{ route('admin.riders.create') }}" class="btn-secondary">+ Add Rider</a>
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

