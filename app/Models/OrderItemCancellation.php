<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use App\Modules\Order\Enums\OrderCancelItemReasonEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class OrderItemCancellation extends BaseModel
{
    
    protected $fillable = [
        "order_item_id",
        "order_id",
        "quantity",
        "cancelled_by",
        "reason",
        "observation",
        "restock"
    ];

    protected $casts = [
        'reason'    => OrderCancelItemReasonEnum::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    #[Override]
    protected static function boot()
    {
        parent::boot();
        static::creating(function(OrderItemCancellation $model){
            $model->cancelled_by = $model->auth()->id;
        });
    }
}
