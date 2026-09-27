@extends('layouts.site')

@section('title', 'Become a Rider - PSCM')

@section('content')

    <section class="bg-primary-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-secondary-400">Careers</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white">Become a PSCM Rider</h1>
            <p class="mt-4 max-w-2xl text-gray-300">Join our growing network of dedicated riders and earn steady income delivering across Kano State.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-gray-900">Why ride with PSCM?</h2>
                @foreach ([
                    ['icon' => '💰', 'text' => 'Competitive, weekly payouts'],
                    ['icon' => '📱', 'text' => 'Simple app-based dispatch'],
                    ['icon' => '🕒', 'text' => 'Flexible working hours'],
                    ['icon' => '🛡️', 'text' => 'Support and rider insurance'],
                ] as $perk)
                    <div class="flex items-start gap-3">
                        <span class="text-xl">{{ $perk['icon'] }}</span>
                        <p class="text-sm text-gray-600">{{ $perk['text'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-2 card">
                <h2 class="text-xl font-bold text-gray-900">Rider Application</h2>
                <form method="POST" action="{{ route('rider-application.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="full_name" class="label">Full Name</label>
                            <input id="full_name" name="full_name" class="input" value="{{ old('full_name') }}" required>
                            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                        </div>
                        <div>
                            <label for="email" class="label">Email</label>
                            <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="label">Phone Number</label>
                            <input id="phone" name="phone" class="input" value="{{ old('phone') }}" required>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div>
                            <label for="vehicle_type" class="label">Vehicle Type</label>
                            <select id="vehicle_type" name="vehicle_type" class="input" required>
                                <option value="">Select vehicle type</option>
                                <option value="motorcycle" @selected(old('vehicle_type') === 'motorcycle')>Motorcycle</option>
                                <option value="tricycle" @selected(old('vehicle_type') === 'tricycle')>Tricycle (Keke)</option>
                                <option value="van" @selected(old('vehicle_type') === 'van')>Van</option>
                                <option value="truck" @selected(old('vehicle_type') === 'truck')>Truck</option>
                            </select>
                            <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <label for="address" class="label">Home Address</label>
                        <input id="address" name="address" class="input" value="{{ old('address') }}" required>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="plate_number" class="label">Plate Number (if any)</label>
                            <input id="plate_number" name="plate_number" class="input" value="{{ old('plate_number') }}">
                            <x-input-error :messages="$errors->get('plate_number')" class="mt-2" />
                        </div>
                        <div>
                            <label for="license_number" class="label">Driver's License No. (if any)</label>
                            <input id="license_number" name="license_number" class="input" value="{{ old('license_number') }}">
                            <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <label for="message" class="label">Anything else we should know? (optional)</label>
                        <textarea id="message" name="message" rows="4" class="input">{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <button type="submit" class="btn-secondary">Submit Application</button>
                </form>
            </div>
        </div>
    </section>

@endsection
