<?php
namespace App\Modules\Product\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Modules\Product\Repository\ProductRepostory;

final class ProductListUseCase
{
    public function __construct(
        private readonly ProductRepostory $ProductRepostory
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return ProductResource::collection(
            $this->ProductRepostory->findAll($paginate)
        );
    }

    public function listById(Product $Product)
    {
        return new ProductResource($Product);
    }
}