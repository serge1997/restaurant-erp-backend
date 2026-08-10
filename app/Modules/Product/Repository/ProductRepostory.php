<?php
namespace App\Modules\Product\Repository;

use App\Foundation\Base\BaseRepository;
use App\Http\Requests\PaginateRequest;
use App\Models\Product;
use Override;

class ProductRepostory extends BaseRepository
{

    protected array $searchableFields = [
        "name",
        "sku",
        "is_active",
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

    #[Override]
    public function findAll(?PaginateRequest $paginate = null)
    {
        $query = $this->getQuery();
        if ($category = (int)$paginate->category_id) {
            $query->where('category_id', $category);
        }
        return parent::findAll($paginate);
    }
}