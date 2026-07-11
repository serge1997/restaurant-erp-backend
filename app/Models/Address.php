<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Address extends BaseModel
{
    
    protected $fillable = [
        "cep",
        "street",
        "number",
        "neighborhood",
        "city_id",
        "complement",
        'model',
        'model_id'
    ];

    protected $appends = ["city"];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, "city_id");
    }
}
