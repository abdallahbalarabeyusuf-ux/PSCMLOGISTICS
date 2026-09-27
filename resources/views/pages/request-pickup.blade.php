@extends('layouts.site')

@section('title', 'Request Pickup - PSCM')

@section('content')

    <section class="bg-primary-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-secondary-400">Request Pickup</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white">Book a Pickup</h1>
            <p class="mt-4 max-w-2xl text-gray-300">Fill in the details below and our rider will be on the way.</p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 pt-16 sm:px-6 lg:px-8" x-data="{ waMode: false }">
        <div class="card flex flex-wrap items-center justify-between gap-4 bg-secondary-50 border-secondary-100">
            <div>
                <h2 class="font-bold text-gray-900">Prefer WhatsApp?</h2>
                <p class="text-sm text-gray-600">Send us your pickup details instantly and we'll confirm your booking there.</p>
            </div>
            <button type="button" @click="waMode = !waMode" class="btn-secondary shrink-0" x-text="waMode ? 'Use the form instead' : 'Book via WhatsApp'"></button>
        </div>

        <div x-show="waMode" x-cloak x-transition x-data="whatsappBookingForm()" class="card mt-6 space-y-4">
            <h3 class="font-bold text-gray-900">Quick WhatsApp Booking</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="label">Your Name</label>
                    <input class="input" x-model="form.sender_name">
                </div>
                <div>
                    <label class="label">Your Phone</label>
                    <input class="input" x-model="form.sender_phone">
                </div>
                <div class="sm:col-span-2">
                    <label class="label">Pickup Address</label>
                    <input class="input" x-model="form.pickup_address">
                </div>
                <div>
                    <label class="label">Receiver Name</label>
                    <input class="input" x-model="form.receiver_name">
                </div>
                <div>
                    <label class="label">Receiver Phone</label>
                    <input class="input" x-model="form.receiver_phone">
                </div>
                <div class="sm:col-span-2">
                    <label class="label">Delivery Address</label>
                    <input class="input" x-model="form.delivery_address">
                </div>
                <div class="sm:col-span-2">
                    <label class="label">Package Details</label>
                    <input class="input" x-model="form.package_details" placeholder="e.g. 2kg parcel, documents, etc.">
                </div>
            </div>
            <a :href="waLink()" target="_blank" rel="noopener" class="btn-secondary w-full">Send Booking Details on WhatsApp</a>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8" x-data="requestPickupForm()">
        <form method="POST" action="{{ route('shipments.store') }}" class="card space-y-8">
            @csrf

            <div>
                <h2 class="text-lg font-bold text-gray-900">Sender Details</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="sender_name" class="label">Full Name</label>
                        <input id="sender_name" name="sender_name" class="input" value="{{ old('sender_name', auth()->user()->name ?? '') }}" required>
                        <x-input-error :messages="$errors->get('sender_name')" class="mt-2" />
                    </div>
                    <div>
                        <label for="sender_phone" class="label">Phone Number</label>
                        <input id="sender_phone" name="sender_phone" class="input" value="{{ old('sender_phone', auth()->user()->phone ?? '') }}" required>
                        <x-input-error :messages="$errors->get('sender_phone')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <label for="pickup_address" class="label">Pickup Address</label>
                        <input id="pickup_address" name="pickup_address" class="input" value="{{ old('pickup_address') }}" required>
                        <x-input-error :messages="$errors->get('pickup_address')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-900">Receiver Details</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="receiver_name" class="label">Full Name</label>
                        <input id="receiver_name" name="receiver_name" class="input" value="{{ old('receiver_name') }}" required>
                        <x-input-error :messages="$errors->get('receiver_name')" class="mt-2" />
                    </div>
                    <div>
                        <label for="receiver_phone" class="label">Phone Number</label>
                        <input id="receiver_phone" name="receiver_phone" class="input" value="{{ old('receiver_phone') }}" required>
                        <x-input-error :messages="$errors->get('receiver_phone')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <label for="delivery_address" class="label">Delivery Address</label>
                        <input id="delivery_address" name="delivery_address" class="input" value="{{ old('delivery_address') }}" required>
                        <x-input-error :messages="$errors->get('delivery_address')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-900">Package Details</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="package_type" class="label">Package Type</label>
                        <input id="package_type" name="package_type" class="input" value="{{ old('package_type', 'Parcel') }}" required>
                        <x-input-error :messages="$errors->get('package_type')" class="mt-2" />
                    </div>
                    <div>
                        <label for="weight_kg" class="label">Weight (kg)</label>
                        <input id="weight_kg" name="weight_kg" type="number" step="0.1" min="0.1" class="input" x-model.number="weight" @input="estimate()" value="{{ old('weight_kg', 1) }}" required>
                        <x-input-error :messages="$errors->get('weight_kg')" class="mt-2" />
                    </div>
                    <div>
                        <label for="destination_zone" class="label">Destination Zone</label>
                        <select id="destination_zone" name="destination_zone" class="input" x-model="zone" @change="estimate()" required>
                            @foreach ($zones as $z)
                                <option value="{{ $z->code }}" @selected(old('destination_zone') === $z->code)>{{ $z->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('destination_zone')" class="mt-2" />
                    </div>
                    <div>
                        <label for="payment_method" class="label">Payment Method</label>
                        <select id="payment_method" name="payment_method" class="input" required>
                            <option value="pay_on_delivery" @selected(old('payment_method', 'pay_on_delivery') === 'pay_on_delivery')>Pay on Delivery</option>
                            <option value="online" @selected(old('payment_method') === 'online')>Pay Online (Paystack)</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="description" class="label">Package Description (optional)</label>
                        <textarea id="description" name="description" rows="3" class="input">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-4 rounded-lg bg-secondary-50 p-4 text-center" x-cloak x-show="amount">
                    <p class="text-sm text-secondary-700">Estimated Price</p>
                    <p class="text-2xl font-extrabold text-secondary-700">&#8358;<span x-text="amount"></span></p>
                </div>
            </div>

            <button type="submit" class="btn-secondary w-full">Book Pickup</button>
        </form>
    </section>

@endsection

@push('scripts')
<script>
    function whatsappBookingForm() {
        return {
            form: {
                sender_name: '',
                sender_phone: '',
                pickup_address: '',
                receiver_name: '',
                receiver_phone: '',
                delivery_address: '',
                package_details: '',
            },
            waLink() {
                const f = this.form;
                const lines = [
                    'Hello PSCM, I would like to book a pickup:',
                    `Sender: ${f.sender_name} (${f.sender_phone})`,
                    `Pickup Address: ${f.pickup_address}`,
                    `Receiver: ${f.receiver_name} (${f.receiver_phone})`,
                    `Delivery Address: ${f.delivery_address}`,
                    `Package: ${f.package_details}`,
                ];
                return 'https://wa.me/' + @json(config('company.whatsapp_number')) + '?text=' + encodeURIComponent(lines.join('\n'));
            },
        };
    }

    function requestPickupForm() {
        return {
            zone: @json(old('destination_zone', $zones->first()->code ?? '')),
            weight: @json((float) old('weight_kg', 1)),
            amount: null,
            async estimate() {
                if (!this.zone || !this.weight) return;
                try {
                    const response = await fetch(@json(route('pricing.calculate')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ destination_zone: this.zone, weight_kg: this.weight }),
                    });
                    const data = await response.json();
                    this.amount = data.amount;
                } catch (e) {}
            },
            init() {
                this.estimate();
            },
        };
    }
</script>
@endpush
