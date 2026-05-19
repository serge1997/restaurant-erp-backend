<?php
namespace App\Modules\StockMovment\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\StockMovment\StockMovmentResource;
use App\Models\Product;
use App\Models\StockMovment;
use App\Modules\StockMovment\Repository\StockMovmentRepository;

final class StockMovmentListUseCase
{

    public function __construct(
        private StockMovmentRepository $stockMovmentRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return StockMovmentResource::collection(
            $this->stockMovmentRepository->findAll($paginate)
        );
    }

    public function listById(StockMovment $stockMovment)
    {
        return new StockMovmentResource($stockMovment);
    }

    public function listLastProduct(Product $product)
    {
        $lastStockMovment = $this->stockMovmentRepository->findFirstBy(['product_id'], [$product->id]);
        if (!$lastStockMovment) {
            return null;
        }
        return new StockMovmentResource(
            $lastStockMovment
        );
    }
}