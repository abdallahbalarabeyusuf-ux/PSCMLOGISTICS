@extends('layouts.auth')

@section('title', 'Forgot Password - PSCM')

@section('content')
    <h1 class="text-xl font-bold text-gray-900 mb-1">Forgot Password</h1>
    <p class="text-sm text-gray-500 mb-6">No problem. Enter your email and we'll send you a password reset link.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="label">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full">Email Password Reset Link</button>
    </form>
@endsection
