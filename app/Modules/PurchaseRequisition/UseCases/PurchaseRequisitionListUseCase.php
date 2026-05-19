<?php
namespace App\Modules\PurchaseRequisition\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\PurchaseRequisition\PurchaseRequisitionFormResource;
use App\Http\Resources\PurchaseRequisition\PurchaseRequisitionResource;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionItem;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionRepository;

final class PurchaseRequisitionListUseCase
{
    public function __construct(
        private PurchaseRequisitionRepository $purchaseRequisitionRepository
    ){}
    
    public function execute(PaginateRequest $paginate)
    {
        return PurchaseRequisitionResource::collection(
            $this->purchaseRequisitionRepository->findAll($paginate)
        );
    }

    public function listById(PurchaseRequisition $purchaseRequisition)
    {
        return new PurchaseRequisitionFormResource($purchaseRequisition);
    }

    public function listAllUndeliveredProductsById(PurchaseRequisition $purchaseRequisition)
    {
        $products = [];
        $purchaseRequisition->items->each(function(PurchaseRequisitionItem $item) use(&$products){
            if (!$item->isDelivered()) {
                $products[] = new ProductResource($item->product);
            }
        });

        return $products;
    }
}