<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PreRegistration extends BaseModel
{

    protected $fillable = [
        'name',
        'corporate_name',
        'cnpj',
        'phone',
        'comercial_contact',
        'email',
        'account_responsable_phone',
        'account_responsable_email',
        'account_responsable_name',
        'account_responsable_cpf',
        'is_chain',
        'confirmation_token',
        'meta',
        'confirmation_token_expired_at',
        'is_confirmed'
    ];

    protected $casts = [
        "confirmation_token_expired_at" => "datetime"
    ];

    public function asUser(): User
    {
        $user =  new User([
            'name'              => $this->account_responsable_name,
            'username'          => $this->account_responsable_email,
            'phone'             => $this->account_responsable_phone,
            'email'             => $this->account_responsable_email,
            'cpf'               => $this->account_responsable_cpf,    
            'is_active'         => true,
            'gender'            => $this->gender
        ]);
        $user->asGuestUser = true;
        return $user;
    }

    public function asCompany(): RestaurantChain
    {
        $chain =  new RestaurantChain([
            "name"                              => $this->name,
            "corporate_name"                    => $this->corporate_name,
            "cpf_cnpj"                           => $this->cnpj,
            "phone"                             => $this->phone,
            "comercial_contact"                 => $this->comercial_contact,
            "email"                             => $this->email,
            "account_responsable_phone"         => $this->account_responsable_phone,
            "account_responsable_email"         => $this->account_responsable_email,
            "account_responsable_name"          => $this->account_responsable_name,
            "is_active"                         => false,
            'is_chain'                          => $this->is_chain
        ]);
        $chain->asGuestUser = true;
        return $chain;
    }

    public function asRestaurant(): Restaurant
    {
        $restaurant = new Restaurant([
            'name'                      => $this->name,
            'corporate_name'            => $this->corporate_name,
            'phone'                     => $this->comercial_contact,
            'email'                     => $this->email ?? $this->account_responsable_email,
            'corporate_registration'    => $this->cnpj, //cpf cnpj
            'is_active'                 => false
        ]);
        $restaurant->asGuestUser = true;
        return $restaurant;
    }

    public static function generateRegistrationConfirmationToken(): string
    {
        return Str::random(64);
    }

    public function confirmRegistrationUrl(): string
    {
        return config('services.vue_app') . "/register/confirmation?token=" . $this->confirmation_token;
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'model_id')->where('model', PreRegistration::class);
    }

    public function confirmationTokenIsExpired(): bool
    {
        if ($this->confirmation_token_expired_at <= now()){
            return true;
        }
        return false;
    }

    public function getMetaAttribute(?string $value): array
    {
        if(!$value) return [];
        return json_decode($value);
    }

    public function responsableAddressId(): ?int
    {
        $address = array_find($this->meta, fn($obj) => property_exists($obj, "account_responsable_address"));
        return (int)$address?->account_responsable_address;
    }

    public function companyAddressId(): int
    {
        $address = array_find($this->meta, fn($obj) => property_exists($obj, "company_address"));
        return (int)$address?->company_address;
    }
}
