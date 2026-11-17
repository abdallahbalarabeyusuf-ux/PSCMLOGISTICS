<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\PricingZone;
use App\Models\Shipment;
use App\Services\SmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShipmentPricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_pickup_form_does_not_collect_weight_or_calculate_the_price(): void
    {
        $response = $this->get(route('shipments.create'));

        $response->assertOk()
            ->assertDontSee('Weight (kg)')
            ->assertDontSee('name="weight_kg"', false)
            ->assertSee('update the estimated price before payment is available');
    }

    public function test_new_shipment_has_no_price_until_an_admin_sets_it(): void
    {
        PricingZone::create([
            'code' => 'within_kano',
            'name' => 'Within Kano',
            'base_fee' => 100,
            'rate_per_kg' => 10,
        ]);
        Storage::fake('public');
        $this->mock(SmsService::class, function ($mock): void {
            $mock->shouldReceive('send')->once()->andReturn(false);
        });

        $this->post(route('shipments.store'), [
            'sender_name' => 'Sender',
            'sender_phone' => '08000000000',
            'pickup_address' => 'Pickup address',
            'receiver_name' => 'Receiver',
            'receiver_phone' => '08000000001',
            'delivery_address' => 'Delivery address',
            'package_type' => 'Parcel',
            'description' => 'Books',
            'destination_zone' => 'within_kano',
            'payment_method' => 'online',
            'weight_kg' => 12,
            'amount' => 50000,
        ])->assertRedirect();

        $shipment = Shipment::firstOrFail();
        $this->assertSame(0.0, (float) $shipment->amount);
        $this->assertSame(1.0, (float) $shipment->getRawOriginal('weight_kg'));

        $this->get(route('shipments.confirmation', $shipment))
            ->assertOk()
            ->assertSee('Pending admin estimate')
            ->assertDontSee('Pay Now');
    }

    public function test_public_pricing_calculator_uses_trip_distance(): void
    {
        $this->postJson(route('pricing.calculate'), [
            'distance_km' => 3,
        ])->assertOk()->assertExactJson([
            'amount' => '5,000.00',
        ]);
    }

    public function test_admin_can_set_the_estimated_price(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password',
        ]);
        $shipment = $this->createShipment('PSCMTEST001');

        $this->actingAs($admin, 'admin')
            ->put(route('admin.shipments.update', $shipment), [
                'rider_id' => null,
                'payment_status' => 'unpaid',
                'distance_km' => 3,
                'amount' => null,
            ])
            ->assertRedirect();

        $this->assertSame(3.0, (float) $shipment->fresh()->distance_km);
        $this->assertSame(5000.0, (float) $shipment->fresh()->amount);
    }

    public function test_admin_can_adjust_the_distance_based_estimate(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password',
        ]);
        $shipment = $this->createShipment('PSCMTEST003');

        $this->actingAs($admin, 'admin')
            ->put(route('admin.shipments.update', $shipment), [
                'rider_id' => null,
                'payment_status' => 'unpaid',
                'distance_km' => 3,
                'amount' => 5500,
            ])
            ->assertRedirect();

        $this->assertSame(5500.0, (float) $shipment->fresh()->amount);
    }

    public function test_online_payment_cannot_start_before_an_admin_sets_the_price(): void
    {
        $shipment = $this->createShipment('PSCMTEST002');

        $this->get(route('payments.pay', $shipment))
            ->assertRedirect(route('shipments.show', $shipment))
            ->assertSessionHasErrors('payment');
    }

    private function createShipment(string $waybill): Shipment
    {
        return Shipment::create([
            'waybill_number' => $waybill,
            'sender_name' => 'Sender',
            'sender_phone' => '08000000000',
            'pickup_address' => 'Pickup address',
            'receiver_name' => 'Receiver',
            'receiver_phone' => '08000000001',
            'delivery_address' => 'Delivery address',
            'package_type' => 'Parcel',
            'destination_zone' => 'within_kano',
            'payment_method' => 'online',
            'amount' => 0,
        ]);
    }
}
