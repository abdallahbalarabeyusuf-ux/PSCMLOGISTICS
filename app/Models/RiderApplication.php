<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RiderApplication extends Model
{
    use HasUuids;
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'vehicle_type',
        'plate_number',
        'license_number',
        'message',
        'status',
    ];
}
