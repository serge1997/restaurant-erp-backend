<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicalSheet extends BaseModel
{
    protected $fillable = [
        "menu_item_id",
        "product_id",
        "quantity",
    ];

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function computeCost(): float
    {
        if ($this->product->category->unit_measure->isUnit()){
            return $this->product->cost;
        }
        if ($this->product->category->unit_measure->isMl() || $this->product->category->unit_measure->isGramm()){
            $cost = $this->quantity * $this->product->cost / $this->product->unit_contain;
            return $cost;
        }
        return 0;
    }
}
