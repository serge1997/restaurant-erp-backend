<?php
namespace App\Http\Resources\Product;

use App\Foundation\Base\BaseJsonResource;
use Illuminate\Http\Request;

class ProductResourceMinified extends BaseJsonResource
{

    public function toArray(Request $request)
    {
        return [
            "id" => $this->id,
            "name"  => $this->name
        ];
    }
}