<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Reservation\Enums\ReservationStatusEnum;

class Reservation extends BaseModel
{
    protected $fillable = [
        'customer',
        'date',
        'hour',
        'quantity_of_person',
        'observation',
        'table_id',
        'restaurant_id',
        'created_by',
        'status'
    ];

    protected $casts = [
        'status'    => ReservationStatusEnum::class
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}
