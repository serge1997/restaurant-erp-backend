<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MenuItem extends BaseModel
{
    
    protected $fillable = [
        "name",
        "code",
        "description",
        "image",
        "price",
        "restaurant_id",
        "category_id",
        "is_active",
        "enable_technical_sheet",

        "cooking_time",
        "for_quantity_of_person",
        "promotional_price",
        "featured_types"
    ];

    protected $casts = [
        "enable_technical_sheet"    => "boolean",
        "is_active"                 => "boolean",
        "cooking_time"              => "datetime"
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function(MenuItem $model) {
            $categoryInicial = $model->category->nameInicial();
            $restaurantInicial = $model->restaurant->nameInicial();
            $randAlfN = strtoupper(Str::random(length: 4));
            $code = "{$restaurantInicial}-{$categoryInicial}-{$randAlfN}";
            $tentative = 0;
            do{
                $randAlfN = strtoupper(Str::random(length: 4));
                $code = "{$restaurantInicial}-{$categoryInicial}-{$randAlfN}";
                $tentative += 1;
                if ($tentative === parent::GENERATE_CODE_TENTATIVE) {
                    $code = $model->id;
                    break;
                }
            }while(MenuItem::where("code", $code)->exists());
            $model->code = $code;
            $model->saveQuietly();
        });
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: function($value) : string {
                if (blank($value)) {
                    return $this->category->image;
                }
                return asset("storage/menu_items/{$value}");
            }
        );
    }
    public function featuredTypes(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? array_map(fn($v) => (int)$v, explode(",", $value)) : []
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, "category_id");
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function enableTechnicalSheetLabel(): string
    {
        return $this->enable_technical_sheet ? "Ativo" : "Inativo";
    }

    public function technicalSheet(): HasMany
    {
        return $this->hasMany(TechnicalSheet::class);
    }

    public function isEnableTechnicalheet(): bool
    {
        return $this->enable_technical_sheet;
    }
}
