<?php

namespace App\Http\Resources\MenuCategory;

use App\Foundation\Base\BaseJsonResource;
use Illuminate\Http\Request;

class MenuCategoryResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request),$this->timestamps());
    }
}
