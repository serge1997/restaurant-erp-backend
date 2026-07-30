<?php

namespace App\Http\Resources\PreRegistration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PreRegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                                => $this->id,
            'name'                              =>  $this->name,
            'corporate_name'                    =>  $this->corporate_name,
            'cnpj'                              =>  $this->cnpj,
            'phone'                             =>  $this->phone,
            'comercial_contact'                 =>  $this->comercial_contact,
            'email'                             =>  $this->email,
            'account_responsable_phone'         =>  $this->account_responsable_phone,
            'account_responsable_email'         =>  $this->account_responsable_email,
            'account_responsable_name'          =>  $this->account_responsable_name,
            'account_responsable_avatar'        => $this->nameInicial($this->account_responsable_name),
            'account_responsable_cpf'           =>  $this->account_responsable_cpf,
            'is_chain'                          =>  $this->is_chain,
            'confirmation_token_expired'        => $this->confirmationTokenIsExpired()
        ];
    }
}
