<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;

class Address extends BaseModel
{
    
    protected $fillable = [
        "cep",
        "street",
        "number",
        "neighborhood",
        "city" ,
        "state",
        "complement",
        'model',
        'model_id'
    ];
}
