<?php

namespace App\Http\Resources\TechnicalSheet;

use App\Http\Resources\MenuItem\MenuItemResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicalSheetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"    => $this->id,
            "menu_item" => new MenuItemResource($this->menuItem),
            "product"   => new ProductResource($this->product),
            "quantity"  => $this->quantity
        ];
    }
}
