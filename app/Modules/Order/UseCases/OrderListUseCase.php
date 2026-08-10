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
        $diff = $yesterDayRevenu - $todayRevenu;
        $diffPercTodayVsYesterdayRevenu = $diff < 0 ? 100 : ($diff == 0 ? 0.00 : $diff * 100 / $yesterDayRevenu);

        $openings = $this->orderRepository->findBy(['status'], OrderStatusEnum::OPEN->value);

        $closedToday = $this->orderRepository->findAllClosed();
        $closedYesterday = count($this->orderRepository->findBy(['status', 'business_day'], OrderStatusEnum::CLOSED->value, $yesterday));
        $closedDiff = $closedYesterday - $closedToday->count();
        $closedPerc = $closedDiff < 0 ? 100 : ($closedDiff == 0 ? 0.00 : $closedDiff * 100 / $closedYesterday);

        $todayMediumTicket = $this->orderRepository->mediumTicket()[0]?->average;
        $yesterdayMediumTicket = $this->orderRepository->mediumTicket($yesterday)[0]?->average;
        $mediumTicketDiff = $yesterdayMediumTicket - $todayMediumTicket;
        $mediumTicketPerc = $mediumTicketDiff < 0 ? 100 : ($mediumTicketDiff == 0 ? 0.00 : $mediumTicketDiff * 100 / $yesterdayMediumTicket);

        $freeTables = $this->tableRepository->findAllAvailable();
        $allTables = $this->tableRepository->findAll();

        $cancelledToday = $this->orderRepository->findAllCanceled();
        $cancelledYesterday = $this->orderRepository->findAllCanceled($yesterday);
        return  [
            'today' => [
                'amount'    => (float)$todayRevenu,
                'diff'      => $diffPercTodayVsYesterdayRevenu
            ],
            'opening' => [
                'quantity'  => count($openings)
            ],
            'closed'    => [
                'quantity'  => $closedToday->count(),
                'diff'  => $closedPerc
            ],
            'medium_ticket' => [
                'amount'    => (float)number_format($todayMediumTicket, 2, '.', '.'),
                'diff'      => $mediumTicketPerc
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
}