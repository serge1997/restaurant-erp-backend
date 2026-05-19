<?php
namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

class MenuCategory extends BaseModel
{

    protected $casts = [
        'is_active'
    ];
    protected $fillable = [
        "image",
        "description",
        "name",
        "is_active"
    ];


    public function image(): Attribute
    {
        return Attribute::make(
            get: function($value) : string {
                if (blank($value)) {
                    return asset("images/menu-category/placeholder-category.webp");
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