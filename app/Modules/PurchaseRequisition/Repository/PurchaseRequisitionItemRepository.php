<?php
namespace App\Modules\PurchaseRequisition\Repository;

use App\Models\Product;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionItem;

class PurchaseRequisitionItemRepository
{
    public function __construct(
        private readonly PurchaseRequisitionItem $purchaseRequisitionItem
    ){}

    public function save(PurchaseRequisition $purchaseRequisition, array $items)
    {
        $purchaseRequisition->items()->saveMany($items);
    }

    public function find(int $id): PurchaseRequisitionItem
    {
        return $this->purchaseRequisitionItem->find($id);
    }

    public function findLastDeliveryOfProduct(Product $product)
    {
       return $this->purchaseRequisitionItem->where("product_id", $product->id)->latest()->first();
    }
}