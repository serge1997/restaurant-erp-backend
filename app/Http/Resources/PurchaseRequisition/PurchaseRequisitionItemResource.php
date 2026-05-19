<?php
namespace App\Http\Resources\PurchaseRequisition;

use App\Foundation\Base\BaseJsonResource;
use App\Http\Resources\Product\ProductResourceMinified;
use Illuminate\Http\Request;

class PurchaseRequisitionItemResource extends BaseJsonResource
{

    public function toArray(Request $request)
    {
        return array_merge(parent::toArray($request),
            [
                "received_quantity" => $this->received_quantity ?? 00,
                "product" => new ProductResourceMinified($this->product)
            ]
        );
    }
}