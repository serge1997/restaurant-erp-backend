<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use App\Modules\ProductCategory\Enums\ProductUnitMeasureEnum;

class ProductCategory extends BaseModel
{
    protected $fillable = [
        'name',
        'unit_measure',
        'is_active'
    ];

    protected $casts = [
        "is_active" => "boolean",
        "unit_measure" => ProductUnitMeasureEnum::class
    ];
}
