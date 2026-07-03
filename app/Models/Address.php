<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
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

    #[Override]
    protected static function boot()
    {
        static::creating(function($address){
            if($address->city){
                $city = City::where("name", $address->city);
                if(!$city){
                    throw new BadRequestException("cidade informada nao encontrada. Entre em contato com suporte");
                }
                $address->city_id = $city->id;
            }
        });
        return parent::boot();
    }
}
