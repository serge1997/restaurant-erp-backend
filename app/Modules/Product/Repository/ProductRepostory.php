<?php
namespace App\Modules\Product\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\Product;

class ProductRepostory extends BaseRepository
{

    protected array $searchableFields = [
        "name",
        "sku",
        "is_active",
        "category_id"
    ];
    public function __construct(
        private readonly Product $product
    )
    {
        return parent::__construct();
    }
    public function eloquent(): Product
    {
       return app(Product::class);
    }
}