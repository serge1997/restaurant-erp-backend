<?php
namespace App\Modules\PurchaseRequisition\UseCases;

use App\Http\Resources\PurchaseRequisition\PurchaseRequisitionItemResource;
use App\Modules\Product\Exceptions\ProductNotFountException;
use App\Modules\Product\Repository\ProductRepostory;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionItemRepository;

final class PurchaseRequisitionItemListUseCase
{
    public function __construct(
        private readonly PurchaseRequisitionItemRepository $purchaseRequisitionItemRepository,
        private readonly ProductRepostory $productRepostory
    ){}

    public function listLastDeliveryOfProduct(int $product_id)
    {
        $product = $this->productRepostory->find($product_id);
        if (!$product){
            throw new ProductNotFountException;
        }
        $item =  $this->purchaseRequisitionItemRepository->findLastDeliveryOfProduct($product);
        if (!$item) return null;
        return new PurchaseRequisitionItemResource($item);
    }
}