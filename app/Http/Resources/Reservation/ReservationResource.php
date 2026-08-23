<?php

namespace App\Http\Resources\Reservation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'customer'              => $this->customer,
            'date'                  => $this->date,
            'hour'                  => $this->hour,
            'quantity_of_person'    => $this->quantity_of_person,
            'observation'           => $this->observation,
            'table' => [
                'id'                => $this->table->id,
                'number'            => $this->table->number
            ],
            'status'    => [
                'value'             => $this->status->value,
                'label'             => $this->status->getLabel(),
                'severity'          => ''
            ],
            'duration'              => $this->duration,
            'waiter'    => $this->when($this->waiter,[
                'id'                => $this->waiter?->id,
                'name'              => $this->waiter?->name
            ])
        ];
    }
}
