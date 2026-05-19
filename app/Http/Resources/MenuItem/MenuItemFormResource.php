<?php

namespace App\Http\Resources\MenuItem;

use App\Http\Resources\TechnicalSheet\TechnicalSheetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            "id"    => $this->id,
            "code"  => $this->code,
            "name"  => $this->name,
            "description"   => $this->description,
            "image" => $this->image,
            "price" => [
                "label" => $this->getPrice(),
                "value" => $this->price
            ],
            "category"  => [
                "id"    => $this->category->id,
                "name"  => $this->category->name
            ],
            "is_active" => $this->is_active,
            "for_quantity_of_person"    => $this->for_quantity_of_person,
            "promotional_price"         => $this->promotional_price,
            "featured_types"            => $this->featured_types,
            "cooking_time"  => $this->cooking_time?->format("H:i"),
            "cooking_time_label"         => dateToTimeHurmanFormat($this->cooking_time),
            "technicalSheet"    => TechnicalSheetResource::collection($this->technicalSheet),
            "enable_technical_sheet"    => [
                "label"     => $this->enableTechnicalSheetLabel(),
                "value"     => $this->enable_technical_sheet
            ]
        ];
    }
}
