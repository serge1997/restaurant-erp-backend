<?php
namespace App\Modules\ProductCategory\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\ProductCategory\ProductCategoryResource;
use App\Models\ProductCategory;
use App\Modules\ProductCategory\Repository\ProductCategoryRepository;
final class ProductCategoryListUseCase
{
    public function __construct(
        private readonly ProductCategoryRepository $productCategoryRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return ProductCategoryResource::collection(
            $this->productCategoryRepository->findAll($paginate)
        );
    }

    public function listById(ProductCategory $productCategory)
    {
        return new ProductCategoryResource($productCategory);
    }
}