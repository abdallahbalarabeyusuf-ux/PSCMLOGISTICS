<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\RiderFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'vehicle_type',
        'plate_number',
        'photo',
        'status',
        'password',
        'current_lat',
        'current_lng',
        'location_updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'current_lat' => 'decimal:7',
            'current_lng' => 'decimal:7',
            'location_updated_at' => 'datetime',
        ];
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}
