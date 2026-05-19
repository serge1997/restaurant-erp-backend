<?php
namespace App\Modules\Order\UseCases;


use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Modules\Order\Infra\OrderRepository;

final class OrderListUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        $orders = $this->orderRepository->findAll($paginate);
        return OrderResource::collection(
           $orders
        )->additional([
            'opened_count'    => $this->orderRepository->findAllOpened()->count(),
            'closed_count'    => $this->orderRepository->findAllClosed()->count(),
            'canceled_count'  => $this->orderRepository->findAllCanceled()->count(),
            'sent_count'    => 0,
            'delivered_count'   => 0,
            'business_day_revenue'  => $this->orderRepository->sumRevenueByBusinessDay()[0]->revenue,
            'total_count'   => $this->orderRepository->findAllByBusinessDay($paginate)->count()
        ]);
    }

    public function listById(Order $order)
    {
        return new OrderResource($order);
    }
}