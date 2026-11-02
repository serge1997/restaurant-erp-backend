<?php
namespace App\Modules\Order\UseCases;

use App\Http\Requests\Order\OrderUpdateRequest;
use App\Models\OrderItem;
use App\Modules\Alert\Infra\Repository\AlertRepository;
use App\Modules\Order\Exceptions\OrderException;
use App\Modules\Order\Infra\OrderRepository;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
use App\Modules\StockMovment\Handlers\StockMovmentHandler;
use App\Modules\StockMovment\Repository\StockMovmentRepository;
use Illuminate\Support\Facades\DB;

final class OrderUpdateUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly StockMovmentRepository $stockMovmentRepository,
        private readonly AlertRepository $alertRepository
    ){}

    public function execute(OrderUpdateRequest $request)
    {
        $payload = $request->validated();
        /** @var \App\Models\Order $order */
        $order = $this->orderRepository->find($payload['id']);
        if (!$order){
            throw OrderException::notFound();
        }
        DB::transaction(function() use($order, $payload){
            $toSave = [];
            $items = $order->items;
            $payloadItems =  $payload['items'];
            foreach($payloadItems as $payloadItem) {
                if(!$order->hasItem($payloadItem["menu_item_id"])) {
                    $toSave[] = new OrderItem($payloadItem);
                    continue;
                }
                if($order->hasItem($payloadItem["menu_item_id"])){
                    $item = $items->where('menu_item_id', $payloadItem['menu_item_id'])->first();
                    $payloadItem['quantity'] = $payloadItem['quantity'] + $item->quantity;
                    $item->update($payloadItem);
                }
            }
            if ($toSave != []){
                $order->items()->saveMany($toSave);
            }
            $stockMovementHandler = new StockMovmentHandler($this->stockMovmentRepository, $this->alertRepository);
            $handler = $stockMovementHandler->handler(StockMovmentReferenceTypeEnum::SALE);
            $handler->handle($order, $payload);
        });
    }
}