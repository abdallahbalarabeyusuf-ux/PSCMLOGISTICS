<?php

namespace App\Services;

use App\Models\PricingZone;

class PricingService
{
    public function calculate(string $zoneCode, float $weightKg): float
    {
        $zone = PricingZone::where('code', $zoneCode)->first();

        if (! $zone) {
            $zone = PricingZone::orderBy('base_fee')->first();
        }

        if (! $zone) {
            return 0;
        }

        $weight = max($weightKg, 1);

        return (float) $zone->base_fee + ((float) $zone->rate_per_kg * $weight);
    }
}
