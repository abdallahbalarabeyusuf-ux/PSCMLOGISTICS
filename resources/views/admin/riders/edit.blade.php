@extends('layouts.admin')

@section('title', 'Edit Rider')

@section('content')
    <div class="card max-w-2xl">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Edit Rider</h2>
        <form method="POST" action="{{ route('admin.riders.update', $rider) }}">
            @method('PUT')
            @include('admin.riders._form')
        </form>
    </div>
@endsection
