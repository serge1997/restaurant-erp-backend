<?php
namespace App\Modules\Order\UseCases;

use App\Http\Requests\Order\OrderTransfertRequest;
use App\Models\OrderItem;
use App\Modules\Order\Exceptions\OrderException;
use App\Modules\Order\Infra\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

final class OrderTransfertUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ){}

    public function execute(OrderTransfertRequest $request)
    {
        $payload = $request->validated();
        $order = $this->orderRepository->find($payload['id']);
        if(!$order){
            throw OrderException::notFound();
        }
        Gate::authorize("update", $order);
        
        $itemsPayload = [];
        $itensIds = array_column($payload['items'], 'menu_item_id');
        $payload['parent_order_id'] = $order->id;
        $orderItens = $order->items;
        foreach($payload['items'] as $orderItem) {
            $find = $orderItens->first(fn($oi)  => $oi->menu_item_id == $orderItem['menu_item_id']);
            if ($find->quantity < $orderItem['quantity']){
                throw new OrderException("Quantidade a transferir nao pode ser maior que a quantidade já pedido.", 400);
            }
            $orderItem['unit_price'] = $find->unit_price;
            $itemsPayload[] = new OrderItem($orderItem);
        }
        DB::transaction(function() use($itemsPayload, $itensIds, $order, $payload){
            $newOrder = $this->orderRepository->save($payload);
            $order->items()->whereIn('menu_item_id', $itensIds)->delete();
            $newOrder->items()->saveMany($itemsPayload);
        });
    }
}