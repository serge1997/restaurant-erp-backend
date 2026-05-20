<?php
namespace App\Modules\Order\UseCases;

use App\Http\Requests\Order\OrderCancelItemRequest;
use App\Http\Requests\Order\OrderCancelRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Modules\Order\Enums\OrderStatusEnum;
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

    public function execute(OrderCancelRequest $request)
    {
        $payload = $request->validated();
        if (!$payload['is_confirmed']){
            throw new OrderException("voce precisa confirma o cancelamento para concluir.", 404);
        }
        /** @var Order $order */
        $order = $this->orderRepository->find($payload['id']);
        if (!$order){
            throw OrderException::notFound();
        }
        $reset_stock_quantities = [];
        DB::transaction(function() use($order, $payload, &$reset_stock_quantities) {
            $order->update(['status' => OrderStatusEnum::CANCELLED->value]);
            foreach ($order->items as $item) {
                // quantidade restante = o que ainda não foi cancelado
                $remainingQty = $item->quantity - $item->quantity_cancelled;
                // só cria se ainda tem quantidade ativa
                if ($remainingQty <= 0) continue;
                $item->update([
                    'quantity_cancelled' => $item->quantity // cancela tudo
                ]);
                if($item->menuItem->technicalSheet && $item->menuItem->isEnableTechnicalheet()){
                    $reset_stock_quantities[$item->id] = $remainingQty;
                }
                $item->itemCancellations()->create([
                    'quantity'     => $remainingQty, // só o que faltava
                    'reason'       => $payload['reason'],
                    'observation'        => $payload['observation'],
                    'restock'      => $payload['restock'],
                ]);
            }
            $payload['reset_stock_quantities'] = $reset_stock_quantities;
            $payload['is_cancelling_order'] = true;
            if($payload['restock']){
                $stockMovementHandler = new StockMovmentHandler($this->stockMovmentRepository);
                $handler = $stockMovementHandler->handler(StockMovmentReferenceTypeEnum::DEVOLUTION_SALE);
                $handler->handle($item, $payload);
            }
        });
    }

    public function executeItem(OrderCancelItemRequest $request)
    {
        
        $payload = $request->validated();
        if (!$payload['is_confirmed']){
            throw new OrderException("voce precisa confirma o cancelamento para concluir.", 422);
        }

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
        $remainingQty = $item->quantity - $item->quantity_cancelled;
        if($remainingQty < $payload["quantity"]){
            throw new OrderException("Quantidade a cancelar não pode ser maior que a quantidade disponível ({$remainingQty}).", 400);
        }
        DB::transaction(function() use($item, $payload, $order){
            $item->update([
                'quantity_cancelled'    => $item->quantity_cancelled + $payload['quantity']
            ]);
            $payload['order_id'] = $payload['id'];
            $item->itemCancellations()->create($payload);
            $payload['is_cancelling_order'] = false;
            if($payload['restock'] && $item->menuItem->technicalSheet && $item->menuItem->isEnableTechnicalheet()){
                $stockMovementHandler = new StockMovmentHandler($this->stockMovmentRepository);
                $handler = $stockMovementHandler->handler(StockMovmentReferenceTypeEnum::DEVOLUTION_SALE);
                $handler->handle($order, $payload);
            }
        });
    }
}