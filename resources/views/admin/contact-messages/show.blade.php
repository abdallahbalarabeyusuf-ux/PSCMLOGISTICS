@extends('layouts.admin')

@section('title', 'Message from ' . $contactMessage->name)

@section('content')

    <a href="{{ route('admin.contact-messages.index') }}" class="text-sm text-primary hover:underline">&larr; Back to messages</a>

    <div class="card mt-4 max-w-2xl">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ $contactMessage->subject ?: 'No Subject' }}</h2>
                <p class="text-sm text-gray-500">From {{ $contactMessage->name }} &lt;{{ $contactMessage->email }}&gt;</p>
                @if ($contactMessage->phone)
                    <p class="text-sm text-gray-500">{{ $contactMessage->phone }}</p>
                @endif
            </div>
            <span class="text-xs text-gray-400">{{ $contactMessage->created_at->format('d M Y, h:ia') }}</span>
        </div>
        <p class="mt-6 whitespace-pre-line text-gray-700">{{ $contactMessage->message }}</p>

        <a href="mailto:{{ $contactMessage->email }}" class="btn-primary mt-6 inline-flex">Reply by Email</a>
    </div>

@endsection
