<?php
namespace App\Modules\Product\UseCases;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Modules\Product\Exceptions\ProductException;
use App\Modules\Product\Repository\ProductRepostory;
use App\Modules\ProductCategory\Repository\ProductCategoryRepository;

final class ProductCreateUseCase
{
    public function __construct(
        private readonly ProductRepostory $ProductRepostory,
        private readonly ProductCategoryRepository $productCategoryRepository
    ){}

    public function execute(ProductCreateRequest $request)
    {
        $productcategory = $this->productCategoryRepository->find($request->category_id);
        if (!$productcategory){
            throw new ProductException("Categoria do produto nao encontrada", 404);
        }
        $this->ProductRepostory->save($request->validated());
    }
}