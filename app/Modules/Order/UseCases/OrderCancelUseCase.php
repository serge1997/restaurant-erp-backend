<?php
namespace App\Modules\Order\UseCases;

use App\Http\Requests\Order\OrderCancelItemRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Modules\Order\Exceptions\OrderException;
use App\Modules\Order\Infra\OrderRepository;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
use App\Modules\StockMovment\Handlers\StockMovmentHandler;
use App\Modules\StockMovment\Repository\StockMovmentRepository;
use Illuminate\Support\Facades\DB;

final class OrderCancelUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly StockMovmentRepository $stockMovmentRepository
    ){}

    public function executeItem(OrderCancelItemRequest $request)
    {
        $payload = $request->validated();

        /** @var Order $order */
        $order = $this->orderRepository->find($payload["id"]);

        if(!$order){
            throw OrderException::notFound();
        }
        /** @var OrderItem $item */
        $item = $order->items()->find($payload['item_id']);

        if(!$item){
            throw new OrderException("item nao foi encontrado no pedido.", 400);
        }
        if(!$item->itemOf($order)){
            throw new OrderException("Operaçao nao pode ser realizada.", 400);
        }
        if($item->quantity < $payload["quantity"]){
            throw new OrderException("Quantidade a cancelar nao pode ser maior que a quantidade do item.", 400);
        }
        DB::transaction(function() use($item, $payload){
            $item->update([
                'quantity_cancelled'    => $item->quantity_cancelled + $payload['quantity']
            ]);
            $payload['order_id'] = $payload['id'];
            $item->itemCancellations()->create($payload);
            if($payload['restock']){
                $stockMovementHandler = new StockMovmentHandler($this->stockMovmentRepository);
                $handler = $stockMovementHandler->handler(StockMovmentReferenceTypeEnum::DEVOLUTION_SALE);
                $handler->handle($item, $payload);
            }
        });
    }
}