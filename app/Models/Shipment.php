<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Shipment extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'waybill_number',
        'user_id',
        'rider_id',
        'sender_name',
        'sender_phone',
        'pickup_address',
        'receiver_name',
        'receiver_phone',
        'delivery_address',
        'package_type',
        'weight_kg',
        'description',
        'destination_zone',
        'amount',
        'payment_status',
        'payment_method',
        'status',
        'qr_code_path',
    ];

    protected function casts(): array
    {
        return [
            'weight_kg' => 'decimal:2',
            'amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Shipment $shipment) {
            if (empty($shipment->waybill_number)) {
                $shipment->waybill_number = 'PSCM' . now()->format('ym') . strtoupper(Str::random(5));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rider(): BelongsTo
    {
        return $this->belongsTo(Rider::class);
    }

    public function trackingUpdates(): HasMany
    {
        return $this->hasMany(ShipmentTrackingUpdate::class)->orderByDesc('created_at');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pending Pickup',
            'picked_up' => 'Picked Up',
            'in_transit' => 'In Transit',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'badge-gray',
            'picked_up', 'in_transit', 'out_for_delivery' => 'badge-blue',
            'delivered' => 'badge-green',
            'cancelled' => 'badge-red',
            default => 'badge-gray',
        };
    }
}
