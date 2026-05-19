<?php

namespace App\Http\Resources\Module;

use App\Http\Resources\Permission\PermissionResource;
use App\Http\Resources\RouteGroup\RouteGroupResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'base_view_path'    => $this->base_view_path,
            'description' => $this->description,
            'icon' => $this->icon,
            'routeGroupes' => RouteGroupResource::collection($this->routeGroupes),
        ];
    }
}
