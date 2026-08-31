<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use App\Modules\Reservation\Enums\ReservationStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Table extends BaseModel
{

    protected $fillable = [
        "restaurant_id",
        "is_active",
        "room_id",
        "capacity",
        "name",
        "number",
        "shape"
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function openingReservation(): HasOne
    {
        return $this->hasOne(Reservation::class)
            ->whereIn('status', [ReservationStatusEnum::CONFIRMED->value, ReservationStatusEnum::PENDING->value])
                ->latest();
    }

    public function hasOpenningReservation(): bool
    {
        return $this->openingReservation()->exists();
    }

    public function hasOpenningReservationAt(string $date): bool
    {
        return $this->openingReservation()->where('date', $date)->exists();
    }

}
