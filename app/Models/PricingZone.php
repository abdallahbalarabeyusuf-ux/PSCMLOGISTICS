<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingZone extends Model
{
    /** @use HasFactory<\Database\Factories\PricingZoneFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'name',
        'base_fee',
        'rate_per_kg',
    ];

    protected function casts(): array
    {
        return [
            'base_fee' => 'decimal:2',
            'rate_per_kg' => 'decimal:2',
        ];
    }
}
