<?php
namespace App\Modules\Table\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\Table;
use App\Modules\Order\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\DB;

class TableRepository extends BaseRepository
{
    public function __construct(
        private Table $table
    ){}

    protected function eloquent(): Table
    {
        return app(Table::class);
    }

    public function findWithActiveOrder()
    {
        $this->whereRestaurantId();
        return $this->getQuery()->select(
            "tables.*",
            "o.id as active_order"
        )->join("orders as o", "o.table_id", "=", "tables.id")
            ->get();
    }

    public function queryTotalCapacity(): int
    {
        return $this->getQuery()->sum("capacity");
    }

    public function findAllAvailable()
    {
        return $this->newQuery()->whereNotIn("tables.id", function($query){
            $query->select("table_id")->from("orders")->where("status", OrderStatusEnum::OPEN->value);
        })->get();
    }

    public function findAllWithOrders()
    {
        
        return $this->getQuery()->select(
            "o.id as order_id",
            "o.customer_name",
            "tables.id as table_id",
            "tables.number as table_number",
            "w.name as waiter_name",
            DB::raw("SUM(oi.unit_price * oi.quantity) as total_price"),
            DB::raw("SUM(oi.quantity) as total_items"),
            DB::raw("case 
                    when TIMESTAMPDIFF(minute, o.created_at, CONVERT_TZ(NOW(), '+00:00', '-03:00')) < 60 then concat(TIMESTAMPDIFF(minute, o.created_at, CONVERT_TZ(NOW(), '+00:00', '-03:00')), 'min')
                    when TIMESTAMPDIFF(minute, o.created_at, CONVERT_TZ(NOW(), '+00:00', '-03:00')) >= 60 and TIMESTAMPDIFF(minute, o.created_at, CONVERT_TZ(NOW(), '+00:00', '-03:00')) < 1440 then concat(TIMESTAMPDIFF(hour, o.created_at, CONVERT_TZ(NOW(), '+00:00', '-03:00')), 'H')
                    else concat(FLOOR(TIMESTAMPDIFF(minute, o.created_at, CONVERT_TZ(NOW(), '+00:00', '-03:00')) / 1440), 'dia(s)')
                end as since
            ")
        )
            ->join("orders as o", "o.table_id", "=", "tables.id")
                ->join("order_items as oi", "oi.order_id", "=", "o.id")
                    ->join("users as w", "w.id", "=", "o.waiter_id")
                        ->whereIn("o.status", [OrderStatusEnum::OPEN->value, OrderStatusEnum::DELIVERED->value, OrderStatusEnum::SENT->value])
                            ->groupBy("o.id", "o.customer_name", "tables.id", "tables.number")
                                ->get();
          
    }

    public function findAllWithOrderStatus()
    {
        return $this->newQuery()
            ->selectRaw("
                tables.id,
                tables.number,
                CASE
                    WHEN orders.status IS NULL OR orders.status IN (1, 2, 3, 5) then 'open'
                    ELSE 'closed' end as status
        ")
            ->leftJoin('orders', function ($join) {
                $join->on('orders.id', '=', DB::raw('(
                    SELECT MAX(id)
                    FROM orders
                    WHERE orders.table_id = tables.id
                )'));
            })->get();
    }
}