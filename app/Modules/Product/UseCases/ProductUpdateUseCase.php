<?php
namespace App\Modules\Product\UseCases;

use App\Http\Requests\Product\ProductUpdateRequest;
use App\Modules\Product\Exceptions\ProductNotFountException;
use App\Modules\Product\Repository\ProductRepostory;

final class ProductUpdateUseCase
{
    public function __construct(
        private readonly ProductRepostory $ProductRepostory
    ){}

    public function execute(ProductUpdateRequest $request)
    {
        $payload = $request->validated();
        $Product = $this->ProductRepostory->find($request->id);
        if (!$Product) {
            throw new ProductNotFountException;
        }
        $this->ProductRepostory->update($Product, $payload);
    }
}