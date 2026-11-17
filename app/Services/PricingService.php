<?php

namespace App\Services;

class PricingService
{
    public function calculate(float $distanceKm): float
    {
        return (float) config('pricing.base_fee')
            + ((float) config('pricing.rate_per_km') * $distanceKm);
    }
}
