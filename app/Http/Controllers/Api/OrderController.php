<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\Order\OrderCancelItemRequest;
use App\Http\Requests\Order\OrderCancelRequest;
use App\Http\Requests\Order\OrderCreateRequest;
use App\Http\Requests\Order\OrderTransfertRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Order;
use App\Modules\Order\UseCases\OrderCancelUseCase;
use App\Modules\Order\UseCases\OrderCreateUseCase;
use App\Modules\Order\UseCases\OrderListUseCase;
use App\Modules\Order\UseCases\OrderTransfertUseCase;
use App\Modules\Order\UseCases\OrderUpdatePaymentMethodUseCase;
use App\Modules\Order\UseCases\OrderUpdateUseCase;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseApiController
{
    
    public function index(PaginateRequest $paginate)
    {
        /** @var OrderListUseCase $useCase */
        $useCase = $this->container->get(OrderListUseCase::class);
        $orders = $useCase->execute($paginate);
        return $this->apiResponse("orders listed successfully", $orders);
    }

    public function store(OrderCreateRequest $rtequest)
    {
        /** @var OrderCreateUseCase $useCase */
        $useCase = $this->container->get(OrderCreateUseCase::class);
        $useCase->execute($rtequest);
        return $this->apiResponse("pedido criado com sucesso");
    }

    public function show(Order $order)
    {
        /** @var OrderListUseCase $useCase */
        $useCase = $this->container->get(OrderListUseCase::class);
        $orders = $useCase->listById($order);
        return $this->apiResponse("showing dealer details", $orders);
    }

    public function update(OrderUpdateRequest $request): JsonResponse
    {
        /** @var OrderUpdateUseCase $useCase */
        $useCase = $this->container->get(OrderUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("pedido alterado com successo");
    }

    public function transfert(OrderTransfertRequest $request): JsonResponse
    {
        /** @var OrderTransfertUseCase $useCase */
        $useCase = $this->container->get(OrderTransfertUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("Pedido transferido com successo.");
    }

    public function paymentMethod(Order $order, int $paymentMethod): JsonResponse
    {
        /** @var OrderUpdatePaymentMethodUseCase $useCase */
        $useCase = $this->container->get(OrderUpdatePaymentMethodUseCase::class);
        $useCase->execute($order, $paymentMethod);
        return $this->apiResponse("Pagamento registrado com successo!");
    }

    public function cancelItem(OrderCancelItemRequest $request): JsonResponse
    {
        /** @var OrderCancelUseCase $useCase */
        $useCase = $this->container->get(OrderCancelUseCase::class);
        $useCase->executeItem($request);
        return $this->apiResponse("Item cancelado com successo !");
    }

    public function cancel(OrderCancelRequest $request): JsonResponse
    {
        /** @var OrderCancelUseCase $useCase */
        $useCase = $this->container->get(OrderCancelUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("Pedido cancelado com successo !");
    }
}
