@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')

    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="py-2 pr-4">From</th>
                        <th class="py-2 pr-4">Subject</th>
                        <th class="py-2 pr-4">Received</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($messages as $message)
                        <tr>
                            <td class="py-3 pr-4">
                                <p class="font-semibold text-gray-900">{{ $message->name }}</p>
                                <p class="text-xs text-gray-400">{{ $message->email }}</p>
                            </td>
                            <td class="py-3 pr-4 text-gray-600">{{ $message->subject ?: '—' }}</td>
                            <td class="py-3 pr-4 text-gray-500">{{ $message->created_at->format('d M Y') }}</td>
                            <td class="py-3 pr-4">
                                <span class="badge {{ $message->is_read ? 'badge-gray' : 'badge-blue' }}">{{ $message->is_read ? 'Read' : 'New' }}</span>
                            </td>
                            <td class="py-3"><a href="{{ route('admin.contact-messages.show', $message) }}" class="text-primary font-semibold hover:underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-8 text-center text-gray-400">No messages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $messages->links() }}</div>
    </div>

@endsection
