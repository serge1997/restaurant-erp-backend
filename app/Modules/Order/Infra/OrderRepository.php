<?php
namespace App\Modules\Order\Infra;


use App\Foundation\Base\BaseRepository;
use App\Http\Requests\PaginateRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Modules\Order\Enums\OrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

use function Laravel\Prompts\select;

class OrderRepository extends BaseRepository
{
    protected array $searchableFields = [
        'customer_name'
    ];
    protected string $businessDay {
        get => Order::getBusinessDay();
    }

    protected function eloquent(): Order
    {
        return app(Order::class);
    }

    public function findAll(?PaginateRequest $paginate = null)
    {
    
        $this->getQuery()->select("orders.*")
            ->where('business_day', Order::getBusinessDay());
        if ($status = $paginate->status) {
            $status = is_array($status) ? $status : [$status];
            $this->getQuery()->whereIn('status', $status);
        }
        if ($paginate->search){
            $this->getQuery()
                ->join('users as u', 'u.id', '=', 'orders.waiter_id')
                    ->join("tables as t", 't.id', '=', 'orders.table_id')
                            ->where(function($query) use($paginate){
                                $query->orWhere([
                                    ['u.name', 'like', "%$paginate->search%"],
                                    ['t.name', 'like', "%$paginate->search%"],
                                    ['orders.customer_name', 'like', "%$paginate->search%"]
                                ]);
                            });
        }
        return parent::findAll($paginate);
    }

    public function history(PaginateRequest $paginate)
    {
        $query = $this->getQuery();
        parent::findAll($paginate);
        if ((int)$paginate->status){
            $query->where('status', $paginate->status);
        }
        if ($payment = (int)$paginate->payment){
            $payment === 1 ? $query->where([
                ['payment_method', null],
                ['status', '<>', OrderStatusEnum::CANCELLED->value]
            ]) : $query->where([
                ['payment_method', '<>', null],
                ['status', '<>', OrderStatusEnum::CANCELLED->value]
            ]);
        }
        if ($paymentMethod = (int)$paginate->paymentMethod){
            $query->where('payment_method', $paymentMethod);
        }
        if ($table = (int)$paginate->table){
            $query->where("orders.table_id", $table);
        }
        if($waiter = (int)$paginate->waiter){
            $query->where("orders.waiter_id", $waiter);
        }
        if($paginate->businessDayFom || $paginate->businessDayTo){
            $to = $paginate->businessDayTo;
            $from = $paginate->businessDayFom;
            if($to && $from){
                $query->whereBetween('business_day', [$from, $to]);
            } else if ($to){
                $query->whereDate('business_day', '<=', $to);
            } else if ($from){
                $query->whereDate('business_day', '>=', $from);
            }
        }
        if($customer = $paginate->customer){
            $query->whereLike('customer_name', "%{$customer}%");
        }
        if($paginate->search) {
            $query->join('users as u', 'u.id', '=', 'orders.waiter_id')
                ->orWhere(function($q) use($paginate){
                    $q->orWhere('u.name', 'like', "%{$paginate->search}%"); 
                });
        }
        $query->orderBy('orders.id', 'desc');
        return $query->get();
    }

    public function openingByTableId(int $table_id)
    {
        return $this->newQuery()->where([
            ['table_id', $table_id]
        ])
            ->whereNotIn('status', [OrderStatusEnum::CLOSED->value, OrderStatusEnum::CANCELLED->value])
                ->first();
    }

    public function findAllOpened(): Collection
    {
        return $this->newQuery()->where('status', OrderStatusEnum::OPEN->value)
            ->whereDate('business_day', $this->businessDay)
                ->get();
    }

    public function findAllClosed(): Collection
    {
        return $this->newQuery()->where('status', OrderStatusEnum::CLOSED->value)
            ->whereDate('business_day', $this->businessDay)
                ->get();
    }

    public function findAllCanceled(?Carbon $date = null): Collection
    {
        $businessDay = Order::getBusinessDay($date);
        return $this->newQuery()->where('status', OrderStatusEnum::CANCELLED->value)
            ->whereDate('business_day', $businessDay)
                ->get();
    }

    public function sumRevenueByBusinessDay(?Carbon $date = null)
    {
        $businessDay = Order::getBusinessDay($date);
        return $this->newQuery()
            ->selectRaw("SUM(oi.quantity * oi.unit_price) as revenue")
                ->join("order_items as oi", "oi.order_id", "=", "orders.id")
                    ->whereDate('business_day', $businessDay)
                        ->get();
    }

    public function findAllByBusinessDay(PaginateRequest $paginate)
    {
        return $this->newQuery()->where('business_day', Order::getBusinessDay())->get();
    }

    public function mediumTicket(?Carbon $date = null)
    {
        $businessDay = Order::getBusinessDay($date);
        return $this->newQuery()
            ->selectRaw("AVG(oi.quantity * oi.unit_price) as average")
                ->join("order_items as oi", "oi.order_id", "=", "orders.id")
                    ->whereDate('business_day', $businessDay)
                        ->get();
    }

    public function activeWaiters()
    {
        return $this->newQuery()
            ->selectRaw("count(distinct orders.waiter_id) as waiters")
                ->join("order_items as oi", "oi.order_id", "=", "orders.id")
                    ->whereDate('business_day', $this->businessDay)
                        ->get();
    }

}