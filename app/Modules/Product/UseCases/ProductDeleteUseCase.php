<?php
namespace App\Modules\Product\UseCases;

use App\Models\Product;
use App\Modules\Product\Repository\ProductRepostory;

final class ProductDeleteUseCase
{
    public function __construct(
        private readonly ProductRepostory $ProductRepostory
    ){}

    public function execute(Product $Product)
    {
        $this->ProductRepostory->delete($Product);
    }
}