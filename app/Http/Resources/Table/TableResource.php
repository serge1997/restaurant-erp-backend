<?php

namespace App\Http\Resources\Table;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            "label" => "Mesa {$this->number} - {$this->capacity} pax",
            "active_order"  => when($this->active_order, $this->active_order, 0),
            "room"  => [
                "name"  => $this->room->name
            ]
        ];
    }
}
