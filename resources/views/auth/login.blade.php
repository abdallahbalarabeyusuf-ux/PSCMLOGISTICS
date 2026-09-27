@extends('layouts.auth')

@section('title', 'Login - PSCM')

@section('content')
    <h1 class="text-xl font-bold text-gray-900 mb-1">Welcome Back</h1>
    <p class="text-sm text-gray-500 mb-6">Log in to your PSCM account to track shipments and manage pickups.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="label">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="label">Password</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary" name="remember">
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-primary hover:underline" href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full">Log in</button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-primary hover:underline">Sign up</a>
    </p>
@endsection
