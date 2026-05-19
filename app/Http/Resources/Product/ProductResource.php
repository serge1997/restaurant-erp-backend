<?php

namespace App\Http\Resources\Product;

use App\Foundation\Base\BaseJsonResource;
use App\Http\Resources\ProductCategory\ProductCategoryResource;
use Illuminate\Http\Request;

class ProductResource extends BaseJsonResource
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
            'category'  => new ProductCategoryResource($this->category),
            'cost'      => [
                "value"     => $this->cost,
                "label"     => $this->getCost()
            ],
            ...$this->timestamps()
            ],
    );
    }
}
