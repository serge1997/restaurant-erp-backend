<?php

namespace App\Http\Resources\Room;

use App\Foundation\Base\BaseJsonResource;
use Illuminate\Http\Request;

class RoomResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
