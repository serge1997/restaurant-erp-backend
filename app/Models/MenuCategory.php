<?php
namespace App\Models;

use App\Foundation\Base\BaseModel;
use App\Modules\MenuCategory\Enums\MenuCategoryTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

class MenuCategory extends BaseModel
{

    protected $casts = [
        'is_active' => 'boolean',
        'type' => MenuCategoryTypeEnum::class
    ];
    protected $fillable = [
        "image",
        "description",
        "name",
        "is_active",
        "type"
    ];


    public function image(): Attribute
    {
        return Attribute::make(
            get: function($value) : string {
                if (blank($value)) {
                    return match($this->name){
                        "Cervejas" => asset("images/menu-category/beer-placeholder.png"),
                        "Vinhos" => asset("images/menu-category/wine-placeholder.png"),
                        "Rum", "Whisky", "Vodka" => asset("images/menu-category/on-the-rocks-placeholder.png"),
                        default => (function(): string{
                            if($this->type === MenuCategoryTypeEnum::BEVERAGE){
                                return asset("images/menu-category/placeholder-beverage.png");
                            }
                            return asset("images/menu-category/placeholder-category.webp");
                        })()
                    };
                }
                return asset("images/menu-category/".$value);
            }
        );
    }

    public function itemImagePlaceholder(): string
    {
        return match(strtolower($this->name)){
            //"entrada", "ocidental" => "",
            default => asset("images/menu-item/beer.png")
        };
    }
}