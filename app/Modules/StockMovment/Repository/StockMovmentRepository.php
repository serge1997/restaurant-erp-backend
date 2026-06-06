<?php
namespace App\Modules\StockMovment\Repository;


use App\Foundation\Base\BaseRepository;
use App\Http\Requests\PaginateRequest;
use App\Models\Product;
use App\Models\StockMovment;

class StockMovmentRepository extends BaseRepository
{
    public function __construct(
        private StockMovment $model
    ){}

    public function eloquent(): StockMovment
    {
        return app(StockMovment::class);
    }

    protected function modelClass(): string
    {
        return StockMovment::class;
    }

    public function findLatestByproduct(Product $product): ?StockMovment
    {
        return $this->model->where("product_id", $product->id)->latest()->first();
    }
    public function findAll(PaginateRequest $paginate)
    {
        $this->getQuery()->selectRaw("DISTINCT(stock_movments.id), stock_movments.*");
        if ($paginate->products) {
            $this->getQuery()->whereIn("stock_movments.product_id", $paginate->products);
        }
        if ($paginate->categories) {
            $this->getQuery()->join("products as p", "p.id", "=", "stock_movments.product_id")
                ->join("product_categories as cat", "cat.id", "=", "p.category_id")
                    ->whereIn("cat.id", $paginate->categories);
        }
        if ($paginate->suppliers) {
            $this->getQuery()->leftJoin("purchase_requisitions as pr", "pr.id", "=", "stock_movments.reference_id")
                ->join("purchase_requisition_items as pi", "pi.purchase_requisition_id", "=", "pr.id")
                    ->whereIn("pi.supplier_id", $paginate->suppliers);
        }
        if ($paginate->reference_types) {
            $this->getQuery()->whereIn("stock_movments.reference_type", $paginate->reference_types);
        }
        if ($paginate->delivery_dateFrom || $paginate->delivery_dateTo){
            $to = $paginate->delivery_dateTo ? $paginate->delivery_dateTo . " 23:59:59" : null;
            $from = $paginate->delivery_dateFrom ? $paginate->delivery_dateFrom . " 00:00:00" : null;
            if ($to && $from) {
                $this->getQuery()->whereBetween("created_at", [$from, $to]);
            }else{
                if ($from) {
                    $this->getQuery()->whereDate("created_at", ">=", $from);
                }
                if ($to) {
                    $this->getQuery()->whereDate("created_at", "<=", $to);
                }
            }
        }
        if ($paginate->moved_dateFrom || $paginate->moved_dateTo){
            $to = $paginate->moved_dateTo ? $paginate->moved_dateTo : null;
            $from = $paginate->moved_dateFrom ? $paginate->moved_dateFrom : null;
            if ($to && $from) {
                $this->getQuery()->whereBetween("moved_at", [$from, $to]);
            }else{
                if ($from) {
                    $this->getQuery()->whereDate("moved_at", ">=", $from);
                }
                if ($to) {
                    $this->getQuery()->whereDate("moved_at", "<=", $to);
                }
            }
        }
        if ($paginate->visualization_type == "true") {
            $this->getQuery()->whereRaw("stock_movments.id IN (select max(id) from restaurantErp.stock_movments group by product_id)");
        }
        return parent::findAll($paginate);
    }
}