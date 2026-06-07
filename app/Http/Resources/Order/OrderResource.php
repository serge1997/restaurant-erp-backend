<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'customer_name' => $this->customer_name,
            'observation'   => $this->observation,
            'status'    => [
                'value' => $this->status->value,
                'label' => $this->status->getLabel(),
                'severity'  => $this->status->getSeverity(),
                'is_cancelled' => $this->status->isCancelled(),
                'is_closed' => $this->status->isClosed()
            ],
            'table' => [
                'id'    => $this->table->id,
                'number'  => $this->table->number,
            ],
            'waiter'    => [
                'id'    => $this->waiter->id,
                'name'  => $this->waiter->name,
                'inicial'   => $this->waiter->nameInicial()
            ],
            'payment_status'   => [
                'value'      => $this->payment_status->value,
                'label' => $this->payment_status->getLabel(),
                'is_paid'   => $this->payment_status->isPaid()
            ],
            'payment_method'    => [
                'value' => $this->payment_method?->value,
                'label' => $this->payment_method?->getLabel(),
                'severity'  => $this->payment_method?->getSeverity()
            ],
            'items' => OrderItemResource::collection($this->items),
            'since' => $this->since(),
            'total' => $this->getTotal(),
            'cancelItems'   => $this->when($this->cancelItems, OrderItemCancellationResource::collection($this->cancelItems)),
            'business_day'  => [
                'original'  => $this->business_day,
                'formatted' => $this->business_day->format('d/m/Y')
            ]
        ];
    }
}
