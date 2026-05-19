<?php
namespace App\Modules\Order\UseCases;

use App\Http\Requests\Order\OrderUpdateRequest;
use App\Models\OrderItem;
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
        private readonly StockMovmentRepository $stockMovmentRepository
    ){}

    public function execute(OrderUpdateRequest $request)
    {
        $payload = $request->validated();
        $order = $this->orderRepository->find($payload['id']);
        if (!$order){
            throw OrderException::notFound();
        }
        DB::transaction(function() use($order, $payload){
            $items = $order->items;
            $payloadItems =  $payload['items'];
            $items->each(function(OrderItem $item) use($payloadItems, &$toSave){
                foreach($payloadItems as $payloadItem) {
                    if (array_key_exists('order_item_id', $payloadItem) == false){
                        $toSave[] = new OrderItem($payloadItem);
                        continue;
                    }
                    if ($payloadItem['order_item_id'] == $item->id){
                        $payloadItem['quantity'] = $payloadItem['quantity'] + $item->quantity;
                        $item->update($payloadItem);
                        continue;
                    }
                }
            });
            if ($toSave != []){
                $order->items()->saveMany($toSave);
            }
            $stockMovementHandler = new StockMovmentHandler($this->stockMovmentRepository);
            $handler = $stockMovementHandler->handler(StockMovmentReferenceTypeEnum::SALE);
            $handler->handle($order, $payload);
            
        });
    }
}