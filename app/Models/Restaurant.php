<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Restaurant extends BaseModel
{
    protected $fillable = [
        'name',
        'corporate_name', //razao social
        'description',
        'phone',
        'email',
        'corporate_registration', //cpf cnpj
        'logo',
        'loss_margim',
        'fix_margim',
        'variable_margim',
        'enable_technical_sheet',
        'is_active',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'enable_technical_sheet' => 'boolean',
    ];

   
    protected function lossMargim(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str_pad(number_format($value, 2), 5, "0", STR_PAD_LEFT)
        );
    }
    protected function fixMargim(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str_pad(number_format($value, 2), 5, "0", STR_PAD_LEFT)
        );
    }
    protected function variableMargim(): Attribute
    {
        return Attribute::make(
            get: fn($value) => str_pad(number_format($value, 2), 5, "0", STR_PAD_LEFT)
        );
    }

    public function logo(): Attribute
    {
        return Attribute::make(
            get: function($value) : ?string {
                if (blank($value)) {
                    return null;
                }
                return asset("storage/restaurants/logos/{$value}");
            }
        );
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'model_id')->where('model', Restaurant::class);
    }
}
