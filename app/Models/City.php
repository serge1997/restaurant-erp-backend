<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends BaseModel
{

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, "uf");
    }
}
