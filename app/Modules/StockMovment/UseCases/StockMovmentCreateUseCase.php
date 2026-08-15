<?php
namespace App\Modules\StockMovment\UseCases;

use App\Http\Requests\StockMovment\StockMovmentCreateRequest;
use App\Models\Product;
use App\Modules\Product\Repository\ProductRepostory;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionRepository;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
use App\Modules\StockMovment\Exceptions\StockMovementException;
use App\Modules\StockMovment\Handlers\StockMovmentHandler;
use App\Modules\StockMovment\Repository\StockMovmentRepository;
use Illuminate\Support\Facades\DB;

final class StockMovmentCreateUseCase
{

    public function __construct(
        private readonly StockMovmentRepository $stockMovmentRepository,
        private readonly PurchaseRequisitionRepository $purchaseRequisitionRepository,
        private readonly ProductRepostory $productRepostory
    ){}

    public function execute(StockMovmentCreateRequest $request)
    {
        $payload = $request->validated();
        $movmentReferenceType = StockMovmentReferenceTypeEnum::from($payload["reference_type"]);
        $product = $this->productRepostory->find($payload["product_id"]);
        $reference = null;
        if ($movmentReferenceType->isPurchase()){
            $reference = $this->purchaseRequisitionRepository->find($payload["reference_id"]);
        }
        if (($movmentReferenceType->isPurchase() || $movmentReferenceType->isSale()) && !$reference) {
            //check this for manual or ajuste
            throw new StockMovementException("Referencia nao encontrada", 400);
        }
        DB::transaction(function() use($movmentReferenceType, $product, $payload, $reference){
            $stockMovementHandler = new StockMovmentHandler($this->stockMovmentRepository);
            $handler = $stockMovementHandler->handler($movmentReferenceType);
            $handler->handle($reference, $payload, $product);
        });
    }
}