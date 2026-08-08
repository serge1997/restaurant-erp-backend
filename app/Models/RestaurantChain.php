<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RestaurantChain extends BaseModel
{
    protected $fillable = [
        "name",
        "corporate_name",
        "cpf_cnpj",
        "phone",
        "comercial_contact",
        "email",
        "account_responsable_phone",
        "account_responsable_email",
        "account_responsable_name",
        "is_active",
        "created_by"
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, "model_id")->where("model", RestaurantChain::class);
    }

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class, "chain_id");
    }
}
