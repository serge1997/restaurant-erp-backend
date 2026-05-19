<?php
namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemCancellationResource extends JsonResource
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
            'quantity'  => $this->quantity,
            'unit_price'    => $this->orderItem->unit_price,
            'reason'    => $this->reason->getLabel(),
            'menu_item' => [
                'id'    => $this->orderItem->menuItem->id,
                'name'  => $this->orderItem->menuItem->name,
                'image' => $this->orderItem->menuItem->image
            ]
        ];
    }
}
