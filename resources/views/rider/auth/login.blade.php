@extends('layouts.auth')

@section('title', 'Rider Login - PSCM')

@section('content')
    <h1 class="text-xl font-bold text-gray-900 mb-1">Rider Login</h1>
    <p class="text-sm text-gray-500 mb-6">Log in to share your live location and view your active deliveries.</p>

    <form method="POST" action="{{ route('rider.login.submit') }}" class="space-y-4">
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

        <label for="remember" class="inline-flex items-center">
            <input id="remember" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary" name="remember">
            <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>

        <button type="submit" class="btn-primary w-full">Log in to Rider Portal</button>
    </form>
@endsection
