<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;

class RestaurantChain extends BaseModel
{
    
    protected $fillable = [
        "name",
        "cpf_cnpj",
        "email",
        "phone",
        "commercial_contact",
        "is_active"
    ];
}
