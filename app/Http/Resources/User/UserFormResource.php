<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFormResource extends JsonResource
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
            'birth_date'    => $this->birth_date?->format('d/m/Y'),
            'address'   => $this->address,
            'roles' => $this->roles()->pluck('id'),
            'roles_permissions'   => RoleResource::collection($this->roles)
        ];
    }
}
