@extends('layouts.auth')

@section('title', 'Confirm Password - PSCM')

@section('content')
    <h1 class="text-xl font-bold text-gray-900 mb-4">Confirm Password</h1>

    <div class="mb-4 text-sm text-gray-600">
        This is a secure area of the application. Please confirm your password before continuing.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <label for="password" class="label">Password</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full">Confirm</button>
    </form>
@endsection
