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
</div>
<p class="mt-4 text-sm text-gray-500">
    Shipment estimates use a base fee of &#8358;{{ number_format(config('pricing.base_fee'), 2) }}
    plus &#8358;{{ number_format(config('pricing.rate_per_km'), 2) }} per kilometer.
</p>
<button type="submit" class="btn-primary mt-6">Save Zone</button>
