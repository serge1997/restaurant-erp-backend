<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'birth_date'    => $this->birth_date?->format("d/m/Y"),
            'inicial'   => $this->nameInicial(),
            'restaurant_id' => $this->restaurant->id,
            'restaurant'    => [
                'id'    => $this->restaurant_id,
                'name'  => $this->restaurant->name,
                'logo'  => $this->restaurant->logo,
                'inicial'   => $this->restaurant->nameInicial(),
                'chain' => [
                    'id' => $this->restaurant->chain?->id,
                    'name' => $this->restaurant->chain?->name
                ]
            ]
        ];
    }
}
