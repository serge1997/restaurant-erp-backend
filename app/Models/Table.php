<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
