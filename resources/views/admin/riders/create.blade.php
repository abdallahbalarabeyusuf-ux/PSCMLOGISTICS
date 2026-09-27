@extends('layouts.admin')

@section('title', 'Add Rider')

@section('content')
    <div class="card max-w-2xl">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Add Rider</h2>
        <form method="POST" action="{{ route('admin.riders.store') }}">
            @include('admin.riders._form')
        </form>
    </div>
@endsection
