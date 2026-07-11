<?php

namespace App\Http\Resources\RestaurantChain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Address\AddressResource;

class RestaurantChainResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "corporate_name" => $this->corporate_name,
            "cpf_cnpj" => $this->cpf_cnpj,
            "phone" => $this->phone,
            "comercial_contact" => $this->comercial_contact,
            "email" => $this->email,
            "is_active" => $this->is_active,
            "account_responsable_phone" => $this->account_responsable_phone,
            "account_responsable_email" => $this->account_responsable_email,
            "account_responsable_name" => $this->account_responsable_name,
            "address" => new AddressResource($this->address),
        ];
    }
}
