<?php
namespace App\Modules\StockMovment\Handlers;

use App\Models\Product;
use App\Foundation\Base\BaseModel;
use App\Models\PurchaseRequisitionItem;
use App\Modules\PurchaseRequisition\Enums\PurchaseRequisitionStatusEnum;
use App\Modules\StockMovment\Exceptions\StockMovementException;
use App\Modules\StockMovment\Repository\StockMovmentRepository;
use App\Modules\StockMovment\Handlers\Contracts\StockMovmentHandlerInterface;


class PurchaseHandler implements StockMovmentHandlerInterface
{

    public function __construct(
        public StockMovmentRepository $stockMovmentRepository
    ){}
    public function handle(?BaseModel $reference, array $payload, ?Product $product = null)
    {
        if ($reference->status->isDraft()) {
            throw new StockMovementException("Preciso da aprovaçao para realizar a entrada de estoque", 400);
        }

        if (!$payload['supplier_id']) {
            throw new StockMovementException("Fornecedor nao informado", 400);
        }
        $purchaseItemProduct = $reference->items->first(fn(PurchaseRequisitionItem $item) => $item->product_id === $product?->id);
        if (!$purchaseItemProduct){
            throw new StockMovementException("Produto nao encontrado na lista de requisiçao", 400);
        }
        if ($purchaseItemProduct->ordered_quantity < $payload['quantity']) {
            throw new StockMovementException("Quandidade pedido nao pode ser menor a quantidade recebida", 400);
        }
        $stockProduct = $this->stockMovmentRepository->findLatestByproduct($product);
        $productUnitMeasure = $product->category->unit_measure;
        $inputQuantity = $payload["quantity"];
        if ($productUnitMeasure->isMl() || $productUnitMeasure->isGramm()) {
            $payload["quantity"] = $payload["quantity"] * $purchaseItemProduct->unit_size;
        }
        if ($productUnitMeasure->isKg()) {
            $payload["quantity"] = $payload["quantity"] * 1000;
        }
        $purchaseItemProduct->update([
            "received_quantity" => $payload["quantity"],
            "cost"              => $payload['cost'],
            "total_cost"        => $payload["cost"] * $inputQuantity,
            "supplier_id"       => $payload["supplier_id"],
            "approved"          => true
        ]);
        if (!$stockProduct) {
            $this->stockMovmentRepository->save($payload);
        }else{
            $payload["quantity"] += $stockProduct->quantity;
            $this->stockMovmentRepository->save($payload);
        }
        if ($reference->isParcial()) {
            $reference->update([
                'status'    => PurchaseRequisitionStatusEnum::PARCIAL->value
            ]);
        }else{
            $reference->update([
                'status'    => PurchaseRequisitionStatusEnum::COMPLETED->value
            ]);
        }
    }
}