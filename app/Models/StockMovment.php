<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use App\Modules\StockMovment\Enums\StockMovmentDirectionEnum;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
use App\Observers\StockMovmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

#[ObservedBy(StockMovmentObserver::class)]
class StockMovment extends BaseModel
{
    
    protected $fillable = [
        "restaurant_id",
        "product_id",
        "quantity",
        "direction", // in | out
        "reference_type", //purchase | sale | devolution_supplier | devolution_sale | waste | adjustment | manual
        "reference_id", //(purchase_request, sale [order], devolution customer or devolution supplier, wast -> gastos),
        "moved_at",
        "created_by",
        "description"
    ];

    protected $casts = [
        "direction" => StockMovmentDirectionEnum::class,
        "reference_type"    => StockMovmentReferenceTypeEnum::class,
        "moved_at"          => "date"
    ];  

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deliveredItem()
    {
        if ($this->reference_type === StockMovmentReferenceTypeEnum::PURCHASE)
            return $this->reference->items()->where("product_id", $this->product_id)->first();
        return (object)[
            'unit_of_measure'   => $this->product->category->unit_measure->getLabel(),
            'received_quantity' => $this->quantity,
            'unit_size' => $this->product->unit_contain
        ];
    }

    public function deliveredQuantity()
    {
        $item = $this->deliveredItem();
        if ($item->unit_of_measure == "KG" || $item->unit_of_measure == "UNIT") {
            return $item->received_quantity;
        }
    }

    public function reference(): BelongsTo
    {
        if ($this->reference_type === StockMovmentReferenceTypeEnum::PURCHASE){
            return $this->belongsTo(PurchaseRequisition::class, "reference_id");
        }
        return $this->belongsTo(Order::class, 'reference_id');
    }

    public function getQuantity(): mixed
    {
        if ($this->product->category->unit_measure->isMl() || $this->product->category->unit_measure->isGramm()){
            if ($this->product->category->unit_measure->isGramm()){
                if ($this->quantity >= 1000) {
                    return $this->quantity / $this->deliveredItem()->unit_size . " KG"; 
                }
                return $this->quantity . " G"; 
            }
            if ($this->product->category->unit_measure->isMl()){
                if($this->quantity < 1000){
                    return $this->quantity . " ml";
                }
            }
            return $this->quantity;
        }
        return $this->quantity;
    }

    public function formatQuantity(float $quantity): string
    {
        if ($this->product->category->unit_measure->isMl() || $this->product->category->unit_measure->isGramm()){
            if ($this->product->category->unit_measure->isGramm()){
                if ($quantity >= 1000) {
                    return $quantity / $this->deliveredItem()->unit_size . " KG"; 
                }
                return $quantity . " G"; 
            }
            if ($this->product->category->unit_measure->isMl()){
                if($quantity < 1000){
                    return $quantity . " ml";
                }
                return number_format($quantity / $this->product->unit_contain, 2) . " un";
            }
        }
        return $quantity;
    }
    public function formatQuantityValue(float $quantity): float
    {
        if ($this->product->category->unit_measure->isMl() || $this->product->category->unit_measure->isGramm()){
            if ($this->product->category->unit_measure->isGramm()){
                if ($quantity >= 1000) {
                    return $quantity / $this->deliveredItem()->unit_size; 
                }
                return $quantity; 
            }
            if ($this->product->category->unit_measure->isMl()){
                if($quantity < 1000){
                    return $quantity;
                }
                return floatval(number_format($quantity / $this->product->unit_contain, 2));
            }
        }
        return $quantity;
    }

    public function inSum(): float
    {
        return $this->where([
            ['direction', StockMovmentDirectionEnum::IN->value],
            ['product_id', $this->product_id]
        ])
            ->whereNot('reference_type', StockMovmentReferenceTypeEnum::DEVOLUTION_SALE->value)
                ->sum('quantity');
    }

    public function outSum(): float
    {
        $devolutionSum = $this->where([
            ['direction', StockMovmentDirectionEnum::IN->value],
            ['product_id', $this->product_id]
        ])
            ->where('reference_type', StockMovmentReferenceTypeEnum::DEVOLUTION_SALE->value)
                ->sum('quantity');
        $out = $this->where([
            ['direction', StockMovmentDirectionEnum::OUT->value],
            ['product_id', $this->product_id]
        ])
            ->sum('quantity');
        return $out - $devolutionSum;
    }
    public function getCurrentStockAttribute(): float
    {
        
        return $this->inSum() - $this->outSum();
    }


    public function inStockLabel(): string
    {
        $quantity = $this->current_stock;
        if ($quantity < 1) {
            return "Indisponivél";
        }
        if($quantity >= $this->product->min_quantity){
            return "Disponivél";
        }
        return "Baixo";
    }

    #[Override]
    public static function boot()
    {
        parent::boot();
        static::creating(function(StockMovment $model){
            if (!$model->moved_at){
                if($model->reference instanceof Order){
                    $model->moved_at = $model->reference->business_day;
                }
                $model->moved_at = now()->format(self::DB_DATE_FORMAT);
            }
            if ($model->reference instanceof PurchaseRequisition){
                if(!$model->reference->delivery_at){
                    $model->reference()->update([
                        'delivery_at'   => now()->format(self::DB_DATE_FORMAT)
                    ]);
                }
            }
            if (!$model->created_by){
                $model->created_by = $model->auth()->id;
            }
        });
    }

    public function quantityIsAlertable(): bool
    {
        return $this->product->min_quantity > $this->current_stock;
    }

    public function stockIsEmpty()
    {
        return $this->current_stock == 0;
    }

    public function stockIsCritical(): bool
    {
        $unitMeasure = $this->product->category->unit_measure;
        $isCritical = $this->current_stock > 0;
        if($unitMeasure->isMl()){
            return $isCritical && $this->current_stock < 200;
        }
        if($unitMeasure->isUnit()){
            return $isCritical && $this->current_stock <= 3;
        }
        if($unitMeasure->isKg()){
            return $isCritical && $this->current_stock <= 1;
        }
        return false;
    }

    
}
