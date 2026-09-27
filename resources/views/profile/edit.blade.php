@extends('layouts.customer')

@section('title', 'My Profile')

@section('content')
    <div class="max-w-2xl space-y-6">
        <div class="card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card border-red-100">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
