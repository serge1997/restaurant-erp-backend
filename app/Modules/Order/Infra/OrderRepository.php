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
    protected array $searchableFields = [];
    protected string $businessDay {
        get => Order::getBusinessDay();
    }

    protected function eloquent(): Order
    {
        return app(Order::class);
    }

    public function findAll(PaginateRequest $paginate)
    {
    
        $this->getQuery()->select("orders.*")
            ->where('business_day', Order::getBusinessDay());
        if ($status = filter_var($paginate->status, FILTER_SANITIZE_NUMBER_INT)) {
            $this->getQuery()->where('status', $status);
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
        if ((int)$paginate->status){
            $query->where('status', $paginate->status);
        }
        if ($payment = (int)$paginate->payment){
            $payment === 1 ? $query->where([
                ['payment_method', null],
                ['status', '<>', OrderStatusEnum::CANCELLED->value]
            ]) : $query->whereNot([
                ['payment_method', null],
                ['status', OrderStatusEnum::CANCELLED->value]
            ]);
        }
        if ($paymentMethod = (int)$paginate->paymentMethod){
            $query->where('payment_method', $paymentMethod);
        }
        if ($table = (int)$paginate->table){
            $query->join("tables as t", "t.id", "=", "orders.table_id")
                ->where("orders.table_id", $table);
        }
        return parent::findAll($paginate);
    }

    public function openingByTableId(int $table_id)
    {
        return $this->newQuery()->where([
            ['table_id', $table_id],
            ['status', '<>', OrderStatusEnum::CLOSED->value]
        ])->first();
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

    public function findAllCanceled(): Collection
    {
        return $this->newQuery()->where('status', OrderStatusEnum::CANCELLED->value)
            ->whereDate('business_day', $this->businessDay)
                ->get();
    }

    public function sumRevenueByBusinessDay()
    {
        $businessDay = Order::getBusinessDay();
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

}