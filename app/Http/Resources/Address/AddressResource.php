<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "cep" => $this->cep,
            "street" => $this->street,
            "number" => $this->number,
            "neighborhood" => $this->neighborhood,
            "city_id" => $this->city_id,
            "state" => $this->city->uf,
            "complement" => $this->complement,
        ];
    }
}
