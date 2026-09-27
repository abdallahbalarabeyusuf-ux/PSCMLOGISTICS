@csrf
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <label class="label">Code (unique, e.g. within_kano)</label>
        <input name="code" class="input" value="{{ old('code', $pricingZone->code ?? '') }}" required>
        <x-input-error :messages="$errors->get('code')" class="mt-2" />
    </div>
    <div>
        <label class="label">Zone Name</label>
        <input name="name" class="input" value="{{ old('name', $pricingZone->name ?? '') }}" required>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <label class="label">Base Fee (&#8358;)</label>
        <input type="number" step="0.01" min="0" name="base_fee" class="input" value="{{ old('base_fee', $pricingZone->base_fee ?? '') }}" required>
        <x-input-error :messages="$errors->get('base_fee')" class="mt-2" />
    </div>
    <div>
        <label class="label">Rate per kg (&#8358;)</label>
        <input type="number" step="0.01" min="0" name="rate_per_kg" class="input" value="{{ old('rate_per_kg', $pricingZone->rate_per_kg ?? '') }}" required>
        <x-input-error :messages="$errors->get('rate_per_kg')" class="mt-2" />
    </div>
</div>
<button type="submit" class="btn-primary mt-6">Save Zone</button>
