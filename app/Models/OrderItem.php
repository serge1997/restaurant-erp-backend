<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends BaseModel
{
    protected $fillable = [
        "order_id",
        "menu_item_id",
        "quantity",
        "unit_price",
        "status",
        "delivered_at",
        "created_by",
        "quantity_cancelled"
    ];

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function itemOf(Order $order): bool
    {
        return $this->order_id === $order->id;
    }

    public function itemCancellations(): HasMany
    {
        return $this->hasMany(OrderItemCancellation::class);
    }

    public function getEffectiveQuantityAttribute(): int
    {
        return $this->quantity - $this->quantity_cancelled;
    }

    public function getEffectiveTotalAttribute(): float
    {
        return $this->effective_quantity * $this->unit_price;
    }
}
