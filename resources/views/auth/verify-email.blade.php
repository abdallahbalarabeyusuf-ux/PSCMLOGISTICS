@extends('layouts.auth')

@section('title', 'Verify Email - PSCM')

@section('content')
    <h1 class="text-xl font-bold text-gray-900 mb-4">Verify Your Email</h1>

    <div class="mb-4 text-sm text-gray-600">
        Thanks for signing up! Before getting started, could you verify your email address by clicking the link we just emailed you? If you didn't receive the email, we'll gladly send another.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-secondary-600">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">Resend Verification Email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-600 underline hover:text-gray-900">Log Out</button>
        </form>
    </div>
@endsection
