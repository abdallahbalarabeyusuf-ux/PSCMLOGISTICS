@extends('layouts.admin')

@section('title', 'Edit Pricing Zone')

@section('content')
    <div class="card max-w-xl">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Edit Pricing Zone</h2>
        <form method="POST" action="{{ route('admin.pricing-zones.update', $pricingZone) }}">
            @method('PUT')
            @include('admin.pricing-zones._form')
        </form>
    </div>
@endsection
