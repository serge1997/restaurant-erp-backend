<?php

namespace App\Http\Resources\Permission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'view_path'  => $this->view_path,
            'description'   => $this->description,
            'guard_name' => $this->guard_name,
            'label' => $this->label,
            'show_in_menu' => $this->show_in_menu,
        ];
    }
}
