<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProfile extends Model
{
    use HasUuids;

    protected $table = 'user_profiles';

    protected $fillable = [
        'id',
        'role',
        'email',
        'full_name',
        'phone',
        'address',
    ];

    public function rider(): HasOne
    {
        return $this->hasOne(Rider::class, 'profile_id');
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'user_id', 'id');
    }
}
