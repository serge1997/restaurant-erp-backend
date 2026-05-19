<?php
namespace App\Foundation\Base;


use Illuminate\Http\Resources\Json\JsonResource;

class BaseJsonResource extends JsonResource
{

    protected function timestamps(): array
    {
        return [
            'created_at' => [
                'formatted' => $this->created_at?->format('d/m/Y'),
                'original' => $this->created_at?->format('d-m-Y')
            ],
            'updated_at' => [
                'formatted' => $this->updated_at?->format('d/m/Y'),
                'original' => $this->updated_at?->format('d-m-Y')
            ]
        ];
    }

    public function getResourceModel()
    {
        return $this->resource;
    }
}