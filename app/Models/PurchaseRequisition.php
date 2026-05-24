<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use App\Modules\PurchaseRequisition\Enums\PurchasePriorityEnum;
use App\Modules\PurchaseRequisition\Enums\PurchaseRequisitionStatusEnum;
use App\Modules\Restaurant\Enums\DepartmentEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PurchaseRequisition extends BaseModel
{
    
    protected $fillable = [
        "restaurant_id",
        "author_id",
        "department",
        "expected_delivery_date",
        "approved_by",
        "approved_at",
        "observation",
        "status",
        "priority",
        "delivery_at"
    ];

    protected $casts = [
        "status" => PurchaseRequisitionStatusEnum::class,
        "department" => DepartmentEnum::class,
        "priority"  => PurchasePriorityEnum::class,
        "expected_delivery_date" => "date",
        "delivery_at"       => "date"
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function(PurchaseRequisition $model){
            $model->author_id = $model->auth()->id;
        });

        static::created(function(PurchaseRequisition $model) {
            $restaurantInicial = $model->restaurant->nameInicial();
            $randAlfN = $model->id . strtoupper(Str::random(length: 3));
            $sku = "{$restaurantInicial}-{$randAlfN}";
            $model->code = $sku;
            $model->saveQuietly();
        });

        static::updated(function(PurchaseRequisition $model){
            if($model->status->isApproved()){
                $model->approved_by = $model->auth()->id;
                $model->approved_at = now()->format('Y-m-d');
                $model->saveQuietly();
            }
        });
    }
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionItem::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function isParcial(): bool
    {
        return $this->items->contains(fn($item) => $item->ordered_quantity > $item->received_quantity);
    }

    public function totalCost(): float
    {
        return $this->items()->sum("total_cost") ?? 0;
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

}
