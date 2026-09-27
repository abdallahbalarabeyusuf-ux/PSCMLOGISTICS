<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\PricingZone;
use App\Models\Rider;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@pscmlogistics.com'],
            ['name' => 'PSCM Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        $zones = [
            ['code' => 'within_kano', 'name' => 'Within Kano Metro', 'base_fee' => 500, 'rate_per_kg' => 100],
            ['code' => 'greater_kano', 'name' => 'Greater Kano (Outskirts)', 'base_fee' => 1000, 'rate_per_kg' => 150],
            ['code' => 'northern_nigeria', 'name' => 'Northern Nigeria (Interstate)', 'base_fee' => 2500, 'rate_per_kg' => 300],
            ['code' => 'other_states', 'name' => 'Other Nigerian States', 'base_fee' => 4000, 'rate_per_kg' => 450],
        ];
        foreach ($zones as $zone) {
            PricingZone::firstOrCreate(['code' => $zone['code']], $zone);
        }

        $customer = User::firstOrCreate(
            ['email' => 'customer@pscmlogistics.com'],
            ['name' => 'Aisha Bello', 'phone' => '08012345678', 'address' => 'No 4 Zoo Road, Kano', 'password' => Hash::make('password')]
        );

        $riders = [
            ['name' => 'Musa Ibrahim', 'email' => 'musa.rider@pscmlogistics.com', 'phone' => '08023456789', 'vehicle_type' => 'motorcycle', 'plate_number' => 'KN-123-ABC', 'status' => 'active'],
            ['name' => 'Chidi Okafor', 'email' => 'chidi.rider@pscmlogistics.com', 'phone' => '08034567890', 'vehicle_type' => 'tricycle', 'plate_number' => 'KN-456-DEF', 'status' => 'active'],
        ];
        foreach ($riders as $rider) {
            Rider::firstOrCreate(['email' => $rider['email']], $rider);
        }

        if (Shipment::count() === 0) {
            $rider = Rider::first();

            $shipment = Shipment::create([
                'user_id' => $customer->id,
                'rider_id' => $rider?->id,
                'sender_name' => $customer->name,
                'sender_phone' => $customer->phone,
                'pickup_address' => 'No 4 Zoo Road, Kano',
                'receiver_name' => 'Tunde Adebayo',
                'receiver_phone' => '08098765432',
                'delivery_address' => 'Sabon Gari Market, Kano',
                'package_type' => 'Documents',
                'weight_kg' => 1.5,
                'description' => 'Sealed envelope with business documents',
                'destination_zone' => 'within_kano',
                'amount' => 650,
                'payment_status' => 'paid',
                'payment_method' => 'pay_on_delivery',
                'status' => 'in_transit',
            ]);

            $shipment->trackingUpdates()->createMany([
                ['status' => 'pending', 'location' => 'No 4 Zoo Road, Kano', 'note' => 'Pickup request received.'],
                ['status' => 'picked_up', 'location' => 'No 4 Zoo Road, Kano', 'note' => 'Package picked up by rider.'],
                ['status' => 'in_transit', 'location' => 'Zoo Road Junction', 'note' => 'On the way to destination.'],
            ]);
        }
    }
}
