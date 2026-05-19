<?php

namespace App\Http\Resources\ProductCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            parent::toArray($request),
            [
                'unit_measure' => [
                    "sheet" => $this->unit_measure->technicalSheetLabel(),
                    "purchase"  => $this->unit_measure->purchaseRequestLabel(),
                    "label" => $this->unit_measure->getLabel()
                ]
            ]
        );
    }
}
