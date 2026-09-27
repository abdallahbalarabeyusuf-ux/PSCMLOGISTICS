@extends('layouts.admin')

@section('title', 'Rider Applications')

@section('content')

    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="py-2 pr-4">Name</th>
                        <th class="py-2 pr-4">Contact</th>
                        <th class="py-2 pr-4">Vehicle</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2 pr-4">Applied</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($applications as $app)
                        <tr>
                            <td class="py-3 pr-4 font-semibold text-gray-900">{{ $app->full_name }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $app->phone }}<br><span class="text-xs text-gray-400">{{ $app->email }}</span></td>
                            <td class="py-3 pr-4 text-gray-600">{{ ucfirst($app->vehicle_type) }}</td>
                            <td class="py-3 pr-4">
                                <span class="badge {{ $app->status === 'approved' ? 'badge-green' : ($app->status === 'rejected' ? 'badge-red' : 'badge-gray') }}">{{ ucfirst($app->status) }}</span>
                            </td>
                            <td class="py-3 pr-4 text-gray-500">{{ $app->created_at->format('d M Y') }}</td>
                            <td class="py-3">
                                @if ($app->status === 'pending')
                                    <div class="flex gap-3">
                                        <form method="POST" action="{{ route('admin.rider-applications.approve', $app) }}">
                                            @csrf
                                            <button type="submit" class="text-secondary font-semibold hover:underline">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.rider-applications.reject', $app) }}">
                                            @csrf
                                            <button type="submit" class="text-red-600 font-semibold hover:underline">Reject</button>
                                        </form>
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-8 text-center text-gray-400">No rider applications yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $applications->links() }}</div>
    </div>

@endsection
