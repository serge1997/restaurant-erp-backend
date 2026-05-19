<?php
namespace App\Modules\ProductCategory\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\ProductCategory;

class ProductCategoryRepository extends BaseRepository
{
    protected array $searchableFields = ["name", "unit_measure"];
    public function __construct(
        private ProductCategory $productCategory
    ){
        parent::__construct();
    }

    protected function eloquent(): ProductCategory
    {
        return app(ProductCategory::class);
    }
}