<?php

namespace App\Http\Resources\PurchaseRequisition;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class PurchaseRequisitionResource extends JsonResource
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
                "status" => [
                    "value" => $this->status->value,
                    "label" => $this->status->getLabel(),
                    "severity" => $this->status->getSeverity(),
                ],
                "priority" => [
                    "value" => $this->priority->value,
                    "label" => $this->priority->getLabel(),
                    "severity" => $this->priority->getSeverity(),
                ],
                "department" => [
                    "value" => $this->department->value,
                    "label" => $this->department->getLabel()
                ],
                'expected_delivery_date' => [
                    'formatted' => $this->expected_delivery_date?->format('Y/m/d'),
                    'original' => $this->expected_delivery_date?->format('d-m-Y')
                ],
                "cost"    => Number::currency($this->totalCost(), "BRL", "pt-BR")
            ]
        );
    }
}
