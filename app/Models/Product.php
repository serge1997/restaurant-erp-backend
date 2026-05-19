<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends BaseModel
{
    
    protected $fillable = [
        "name",
        "description",
        "category_id",
        "cost",
        "unit_contain",
        "min_quantity",
        "restaurant_id",
        "sku",
        "loss_percentage",
        "is_active"
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function(Product $model) {
            $categoryInicial = $model->category->nameInicial();
            $restaurantInicial = $model->restaurant->nameInicial();
            $randAlfN = strtoupper(Str::random(length: 4));
            $sku = "{$restaurantInicial}-{$categoryInicial}-{$randAlfN}";
            $tentative = 0;
            do{
                $randAlfN = strtoupper(Str::random(length: 4));
                $sku = "{$restaurantInicial}-{$categoryInicial}-{$randAlfN}";
                $tentative += 1;
                if ($tentative === parent::GENERATE_CODE_TENTATIVE) {
                    $sku = $model->id;
                    break;
                }
            }while(Product::where("sku", $sku)->exists());
            $model->sku = $sku;
            $model->saveQuietly();
        });
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function getInStockLabel(int $quantity): string
    {
        if ($quantity < 1) {
            return "Indisponivél";
        }
        if($quantity > $this->min_quantity || $quantity === $this->min_quantity){
            return "Disponivél";
        }
        return "Baixo";
    }

    public function getInStockLabelSeverity(int $quantity): string
    {
        if ($quantity < 1) {
            return "tag-purple";
        }
        if($quantity > $this->min_quantity || $quantity === $this->min_quantity){
            return "tag-green-dark";
        }
        return "tag-amber";
    }
}
