<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends BaseModel
{
    protected $fillable = [
        "name",
        "description",
        "restaurant_id",
        "capacity",
        "severity",
        "icon",
        "is_active",
        "room_type_id"
    ];

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function  tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }
}
