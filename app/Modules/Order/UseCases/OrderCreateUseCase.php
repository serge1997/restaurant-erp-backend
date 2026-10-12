<?php
namespace App\Modules\Order\UseCases;

use App\Foundation\Base\BaseUseCase;
use App\Http\Requests\Order\OrderCreateRequest;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Reservation;
use App\Modules\MenuItem\Repository\MenuItemRepository;
use App\Modules\Order\Exceptions\OrderException;
use App\Modules\Order\Infra\OrderRepository;
use App\Modules\Reservation\Infra\Repository\ReservationRepository;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
use App\Modules\StockMovment\Handlers\StockMovmentHandler;
use App\Modules\StockMovment\Repository\StockMovmentRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

final class OrderCreateUseCase extends BaseUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly MenuItemRepository $menuItemRepository,
        private readonly StockMovmentRepository $stockMovmentRepository,
        private readonly ReservationRepository $reservationRepository
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
                        $payloadSideDishes = isset($orderItem["side_dishes"]) ? $orderItem["side_dishes"] : [];
                        $priceToUse = $item->getPriceToUse();
                        unset($orderItem['side_dishes']);
                        $itemPayload[] = [...$orderItem, ...['unit_price' => $priceToUse]];
                        if($payloadSideDishes != []){
                            $sideDishItemsIds = array_column($payloadSideDishes, "id");
                            $sideDishItems = $this->menuItemRepository->findByIds($sideDishItemsIds);
                            $sideDishItems->each(function(MenuItem $sideDishItem) use ($orderItem, &$itemPayload, $payloadSideDishes){
                                $currentSideDish = array_filter($payloadSideDishes, function($sideDish) use ($sideDishItem){
                                    return $sideDish['id'] == $sideDishItem->id;
                                });
                                $itemPayload[] = [
                                        'unit_price'                => $sideDishItem->getPriceToUse(), 
                                        'menu_item_id'              => $sideDishItem->id, 
                                        "parent_order_item_id"      => $orderItem["menu_item_id"],
                                        "quantity"                  => $currentSideDish[0]["quantity"]
                                ];
                            });
                        }
                   }
               }, $payload["items"]);
            });
            $order->items()->createMany($itemPayload);
            $reservation = null;
            if(isset($payload["reservation_id"]) && !empty($payload["reservation_id"])){
                $reservation = $this->reservationRepository->find($payload["reservation_id"]);
            }
            if($reservation instanceof Reservation){
                if(!$reservation->isOwner()){
                    throw new AuthorizationException;
                }
                $reservation->setAsSeated();
            }
            $stockMovementHandler = new StockMovmentHandler($this->stockMovmentRepository);
            $handler = $stockMovementHandler->handler(StockMovmentReferenceTypeEnum::SALE);
            $handler->handle($order, $payload);
        });
    }
}
