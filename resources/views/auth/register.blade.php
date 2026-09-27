@extends('layouts.auth')

@section('title', 'Create Account - PSCM')

@section('content')
    <h1 class="text-xl font-bold text-gray-900 mb-1">Create Your Account</h1>
    <p class="text-sm text-gray-500 mb-6">Sign up to book pickups, track shipments and view your delivery history.</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="label">Full Name</label>
            <input id="name" class="input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="label">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="phone" class="label">Phone Number</label>
            <input id="phone" class="input" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="label">Password</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="label">Confirm Password</label>
            <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full">Create Account</button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Already registered? <a href="{{ route('login') }}" class="font-semibold text-primary hover:underline">Log in</a>
    </p>
@endsection
