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
        "quantity_cancelled",
        "parent_order_item_id"
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


    public function isSideDish(): bool
    {
        return !is_null($this->parent_order_item_id);
    }

    public function itemSideDishes(): HasMany
    {
        return $this->order->allItems()->where('parent_order_item_id', $this->menu_item_id);
    }

    public function hasSideDishes(): bool
    {
        return $this->order->allItems()->where('parent_order_item_id', $this->menu_item_id)->exists();
    }
}
