<?php
namespace App\Modules\PurchaseRequisition\UseCases;

use App\Http\Requests\PurchaseRequisition\PurchaseRequisitionCreateRequest;
use App\Modules\PurchaseRequisition\Exceptions\PurchaseRequisitionException;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionItemRepository;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionRepository;
use Illuminate\Support\Facades\DB;

final class PurchaseRequisitionCreateUseCase
{
    public function __construct(
        private readonly PurchaseRequisitionRepository $purchaseRequisitionRepository,
        private readonly PurchaseRequisitionItemRepository $purchaseRequisitionItemRepository
    ){}
    
    public function execute(PurchaseRequisitionCreateRequest $request)
    {
        DB::transaction(function()use($request){
            $payload = $request->validated();
            $purchaseRequisition = $this->purchaseRequisitionRepository->save($payload);
            if (!$purchaseRequisition) {
                throw new PurchaseRequisitionException("error ao gravar a requisiçao de compra.", 400);
            }
            $purchaseRequisition->items()->createMany($request->getItems());
        });
    }
}