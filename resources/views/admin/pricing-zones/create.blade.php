@extends('layouts.admin')

@section('title', 'Add Pricing Zone')

@section('content')
    <div class="card max-w-xl">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Add Pricing Zone</h2>
        <form method="POST" action="{{ route('admin.pricing-zones.store') }}">
            @include('admin.pricing-zones._form')
        </form>
    </div>
@endsection
