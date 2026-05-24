<?php
namespace App\Modules\PurchaseRequisition\UseCases;


use App\Http\Requests\PurchaseRequisition\PurchaseRequisitionUpdateRequest;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionItem;
use App\Modules\PurchaseRequisition\Enums\PurchaseRequisitionStatusEnum;
use App\Modules\PurchaseRequisition\Exceptions\PurchaseRequisitionException;
use App\Modules\PurchaseRequisition\Exceptions\PurchaseRequisitionNotFountException;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionItemRepository;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionRepository;
use Illuminate\Support\Facades\DB;

final class PurchaseRequisitionUpdateUseCase
{
    public function __construct(
        private PurchaseRequisitionRepository $purchaseRequisitionRepository,
        private PurchaseRequisitionItemRepository $purchaseRequisitionItemRepository
    ){}
    
    public function execute(PurchaseRequisitionUpdateRequest $request)
    {
        $purchaseRequisition = $this->purchaseRequisitionRepository->find($request->id);
        if (!$purchaseRequisition) {
            throw new PurchaseRequisitionNotFountException;
        }
        if (!$purchaseRequisition->status->isEditable()) {
            throw new PurchaseRequisitionException("nao é possivel alterar o a requisiçao devido ao status atual", 400);
        }
        $payload = $request->validated();
        DB::transaction(function() use($payload, $purchaseRequisition, $request){
            unset($payload["status"]);
            $this->purchaseRequisitionRepository->update($purchaseRequisition, $payload);
            $itemIds = array_column($payload['items'], 'id');

            foreach($payload['items'] as $item) {
                if (!array_key_exists("id", $item)) {
                    $purchaseRequisition->items()->create($item);
                    continue;
                }
                $purchaseRequisitionItem = $purchaseRequisition->items->first(fn($requestItem) => $requestItem->id == $item["id"]);
                $purchaseRequisitionItem->update($item);
            }

            $purchaseRequisition->items->each(function(PurchaseRequisitionItem $purchaseRequisitionItem) use ($item, $itemIds){
                if (!in_array($purchaseRequisitionItem->id, $itemIds)) {
                    $purchaseRequisitionItem->delete();
                }
            });
        });
    }

    public function attacheStatus(PurchaseRequisition $purchaseRequisition, int $status): string
    {
        $status = PurchaseRequisitionStatusEnum::from($status);
        $data = [];
        $message = "status alterado com sucesso";
        if ($status->isApproved()) {
            $message = "Requisiçao aprovado com successo";
        }
        if ($status->isRjected()) {
            $message = "Requisiçao rejeitado com successo";
        }
        $this->purchaseRequisitionRepository->attacheStatus($purchaseRequisition, $status);
        return $message;
    }
}