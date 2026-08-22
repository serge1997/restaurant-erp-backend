<?php
namespace App\Modules\Order\UseCases;

use App\Foundation\Base\BaseUseCase;
use App\Http\Requests\Order\OrderCreateRequest;
use App\Models\MenuItem;
use App\Models\Order;
use App\Modules\MenuItem\Repository\MenuItemRepository;
use App\Modules\Order\Exceptions\OrderException;
use App\Modules\Order\Infra\OrderRepository;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
use App\Modules\StockMovment\Handlers\StockMovmentHandler;
use App\Modules\StockMovment\Repository\StockMovmentRepository;
use Illuminate\Support\Facades\DB;

final class OrderCreateUseCase extends BaseUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly MenuItemRepository $menuItemRepository,
        private readonly StockMovmentRepository $stockMovmentRepository
    ){
        parent::__construct($orderRepository);
    }

    public function execute(OrderCreateRequest $request)
    {
        $payload = $request->validated();
        $payload["restaurant_id"] = $this->auth()->restaurant_id;
        $payload["waiter_id"] = $this->auth()->id;
        $tableIsBusy = $this->orderRepository->openingByTableId($payload['table_id']);
        if ($tableIsBusy){
            throw new OrderException("a mesa selecionada está com um pedido aberto.", 400);
        }
        DB::transaction(function() use ($payload) {
            /** @var Order $order */
            $order = $this->orderRepository->save($payload);
            $itemids = array_column($payload["items"], "menu_item_id");
            $items = $this->menuItemRepository->findByIds($itemids);
            $itemPayload = [];
            $items->each(function(MenuItem $item) use ($payload, &$itemPayload){
               array_map(function($orderItem) use ($item, &$itemPayload){
                   if ($orderItem["menu_item_id"] == $item->id){
                        $itemPayload[] = [...$orderItem, ...['unit_price'   => $item->price]];
                   }
               }, $payload["items"]);
            });
            $order->items()->createMany($itemPayload);
            $stockMovementHandler = new StockMovmentHandler($this->stockMovmentRepository);
            $handler = $stockMovementHandler->handler(StockMovmentReferenceTypeEnum::SALE);
            $handler->handle($order, $payload);
        });
    }
}
