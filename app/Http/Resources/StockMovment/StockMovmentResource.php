<?php

namespace App\Http\Resources\StockMovment;

use App\Foundation\Base\BaseJsonResource;
use App\Models\Product;
use Illuminate\Http\Request;

class StockMovmentResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $in = $this->inSum();
        $out = $this->outSum();
        /** @var Product $product */
        $product = $this->product;
        return [
            "id"                => $this->id,
            "description"       => $this->description,
            "direction"         => [
                'label'     =>  $this->reference_type->isDevolutionSale() ? 'Devoluçao venda': $this->direction->getLabel(),
                'severity'  => $this->direction->getSeverity(),
                'color'     => $this->direction->getFontColor()
            ],
            "reference_type"    => $this->reference_type->getLabel(),
            "quantity"          => $this->formatQuantity($this->quantity),
            'current_stock'     => [
                'label' => $this->formatQuantity($this->current_stock),
                'value' => $this->current_stock,
            ],
            "delivery"          => $this->deliveredItem(),
            "in"                => $this->formatQuantity($in),
            "out"               => $this->formatQuantity($out),
            "reference"         => [
                "id"             => $this->reference?->id,
                "code"          => $this->reference?->code ?? $this->reference?->id ?? $this->reference_type->getLabel(),
            ],
            "product"           => [
                "id"    => $product->id,
                "name"  => $product->name,
                "unit_measure_label" => $product->category->unit_measure->purchaseRequestLabel(),
                "db_unit_size_label"    => $product->category->unit_measure->getLabel(),
                "in_stock_label"   => $product->inStock($this->current_stock)->getLabel(),
                "in_stock_label_severity"   => $product->inStock($this->current_stock)->getSeverity()
            ],
            'details' => [],
            'moved_at' => [
                'original' => $this->moved_at,
                'formatted' => $this->moved_at->format("d/m/Y")
            ],
            "created_by" => [
                "id"    => $this->createdBy?->id,
                "name"  => $this->createdBy?->name
            ],
            ...$this->timestamps()
        ];
    }
}
