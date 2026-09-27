@csrf
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <label class="label">Full Name</label>
        <input name="name" class="input" value="{{ old('name', $rider->name ?? '') }}" required>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <label class="label">Email</label>
        <input name="email" type="email" class="input" value="{{ old('email', $rider->email ?? '') }}" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div>
        <label class="label">Phone</label>
        <input name="phone" class="input" value="{{ old('phone', $rider->phone ?? '') }}" required>
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>
    <div>
        <label class="label">Vehicle Type</label>
        <select name="vehicle_type" class="input" required>
            @foreach (['motorcycle' => 'Motorcycle', 'tricycle' => 'Tricycle (Keke)', 'van' => 'Van', 'truck' => 'Truck'] as $value => $label)
                <option value="{{ $value }}" @selected(old('vehicle_type', $rider->vehicle_type ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">Plate Number</label>
        <input name="plate_number" class="input" value="{{ old('plate_number', $rider->plate_number ?? '') }}">
    </div>
    <div>
        <label class="label">Status</label>
        <select name="status" class="input" required>
            <option value="active" @selected(old('status', $rider->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $rider->status ?? '') === 'inactive')>Inactive</option>
        </select>
    </div>
    <div>
        <label class="label">{{ isset($rider) ? 'Reset Portal Password' : 'Portal Password' }}</label>
        <input name="password" type="password" class="input" placeholder="{{ isset($rider) ? 'Leave blank to keep current password' : 'Used for the rider location-sharing portal' }}" autocomplete="new-password">
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>
</div>
<button type="submit" class="btn-primary mt-6">Save Rider</button>
