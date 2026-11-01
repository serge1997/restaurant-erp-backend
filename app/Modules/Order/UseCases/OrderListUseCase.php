<?php
namespace App\Modules\Order\UseCases;


use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Modules\Order\Enums\OrderStatusEnum;
use App\Modules\Order\Infra\OrderRepository;
use App\Modules\Table\Repository\TableRepository;

final class OrderListUseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly TableRepository $tableRepository
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

    public function history(PaginateRequest $paginateRequest)
    {
        return OrderResource::collection(
            $this->orderRepository->history($paginateRequest)
        );
    }

    public function homeKpis()
    {
        $yesterday = now()->subDay();
        $todayRevenu = $this->orderRepository->sumRevenueByBusinessDay()[0]?->revenue ?? 0;
        $yesterDayRevenu = $this->orderRepository->sumRevenueByBusinessDay($yesterday)[0]?->revenue ?? 0;
       

        $openings = $this->orderRepository->findBy(['status'], OrderStatusEnum::OPEN->value);

        $closedToday = $this->orderRepository->findAllClosed()->count();
        $closedYesterday = count($this->orderRepository->findBy(['status', 'business_day'], OrderStatusEnum::CLOSED->value, $yesterday->format('Y-m-d')));

        $todayMediumTicket = $this->orderRepository->mediumTicket()[0]?->average;
        $yesterdayMediumTicket = $this->orderRepository->mediumTicket($yesterday)[0]?->average;
    
        $freeTables = $this->tableRepository->findAllAvailable();
        $allTables = $this->tableRepository->findAll();

        $cancelledToday = $this->orderRepository->findAllCanceled();
        $cancelledYesterday = $this->orderRepository->findAllCanceled($yesterday);
        return  [
            'today' => [
                'amount'    => (float)$todayRevenu,
                'diff'          => $this->computeDiffRate($todayRevenu, $yesterDayRevenu)
            ],
            'opening' => [
                'quantity'  => count($openings)
            ],
            'closed'    => [
                'quantity'  => $closedToday,
                'diff'  => $this->computeDiffRate($closedToday, $closedYesterday)
            ],
            'medium_ticket' => [
                'amount'    => (float)number_format($todayMediumTicket, 2, '.', '.'),
                'diff'  => $this->computeDiffRate($todayMediumTicket, $yesterdayMediumTicket)
            ],
            'tables'    => [
                'free'  => $freeTables->count(),
                'all'   => $allTables->count()
            ],
            'cancelled' => [
                'today' => $cancelledToday->count(),
                'yesterday' => $cancelledYesterday->count()
            ],
            'waiters'   => [
                'quantity'  => $this->orderRepository->activeWaiters()->count()
            ]
        ];
    }

    private function computeDiffRate(?float $today, ?float $yesterday): string
    {
        $today = $today ?? 0;
        $yesterday = $yesterday ?? 0;
        $closedPerc = 0;
        if($yesterday == 0 && $today == 0){
            return $closedPerc;
        }
        if($yesterday == 0) {
            $closedPerc = 100;
        }
        $closedDiff = $today - $yesterday;
        $closedPerc = $closedDiff * 100 / $yesterday;
        return number_format($closedPerc, 2, '.', '.');
    }
}