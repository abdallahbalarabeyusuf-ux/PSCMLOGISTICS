@extends('layouts.site')

@section('title', 'Contact Us - PSCM')

@section('content')

    <section class="bg-primary-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-secondary-400">Contact</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white">Get in Touch</h1>
            <p class="mt-4 max-w-2xl text-gray-300">Have a question or need a custom logistics solution? Our team is here to help.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">

            <div class="lg:col-span-2 card">
                <h2 class="text-xl font-bold text-gray-900">Send us a message</h2>
                <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="label">Full Name</label>
                            <input id="name" name="name" class="input" value="{{ old('name') }}" required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <label for="email" class="label">Email</label>
                            <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="label">Phone (optional)</label>
                            <input id="phone" name="phone" class="input" value="{{ old('phone') }}">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div>
                            <label for="subject" class="label">Subject</label>
                            <input id="subject" name="subject" class="input" value="{{ old('subject') }}">
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <label for="message" class="label">Message</label>
                        <textarea id="message" name="message" rows="5" class="input" required>{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            </div>

            <div class="space-y-6">
                <div class="card">
                    <h3 class="font-bold text-gray-900">Contact Info</h3>
                    <ul class="mt-4 space-y-3 text-sm text-gray-600">
                        <li>📞 {{ config('company.phone_1') }}</li>
                        <li>📞 {{ config('company.phone_2') }}</li>
                        <li>✉️ {{ config('company.email') }}</li>
                        <li>📍 {{ config('company.address') }}</li>
                    </ul>
                </div>
                <div class="card">
                    <h3 class="font-bold text-gray-900">Business Hours</h3>
                    <ul class="mt-4 space-y-1 text-sm text-gray-600">
                        <li>Mon - Fri: 8:00am - 6:00pm</li>
                        <li>Saturday: 9:00am - 4:00pm</li>
                        <li>Sunday: Closed</li>
                    </ul>
                </div>
                <a href="https://wa.me/{{ config('company.whatsapp_number') }}" target="_blank" rel="noopener" class="btn-secondary w-full">Chat on WhatsApp</a>
            </div>
        </div>
    </section>

@endsection
