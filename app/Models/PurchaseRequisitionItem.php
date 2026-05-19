<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequisitionItem extends BaseModel
{
    
    protected $fillable = [
        "purchase_requisition_id",
        "product_id",
        "supplier_id",
        "ordered_quantity",
        "received_quantity",
        "cost",
        "total_cost",
        "unit_size",
        "unit_of_measure",
        "approved"
    ];

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isDelivered(): bool
    {
        return !blank($this->received_quantity);
    }

    protected static function boot()
    {
        parent::boot();
        static::updated(function(PurchaseRequisitionItem $model) {
            $model->product->updateQuietly([
                'cost'  => $model->cost,
                'unit_contain'  => $model->unit_size
            ]);
        });
    }
}
