<?php
namespace App\Modules\PurchaseRequisition\Repository;

use App\Foundation\Base\BaseRepository;
use App\Http\Requests\PaginateRequest;
use App\Models\PurchaseRequisition;
use App\Modules\PurchaseRequisition\Enums\PurchaseRequisitionStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Override;

class PurchaseRequisitionRepository extends BaseRepository
{
    protected array $searchableFields = [];

    public function __construct(
        private PurchaseRequisition $purchaseRequisition
    ){
        parent::__construct();
    }

    #[Override]
    public function findAll(PaginateRequest $paginate)
    {
        $query = $this->getQuery();
        $this->buildFiltersQuery($query, $paginate);
        return parent::findAll($paginate);
    }

    protected function eloquent(): PurchaseRequisition
    {
        return app(PurchaseRequisition::class);
    }

    public function attacheStatus(PurchaseRequisition $model, PurchaseRequisitionStatusEnum $status)
    {
        $model->update([
            "status"    => $status->value,
        ]);
    }

    private function buildFiltersQuery(Builder &$query, PaginateRequest $paginate)
    {
        if($paginate->status) {
            $query->where('status', $paginate->status);
        }
        if($paginate->priority) {
            $query->where('priority', $paginate->priority);
        }
        if($paginate->department){
            $query->whereIn('department', $paginate->department);
        }
        if($paginate->createdAt || $paginate->createdAtTo) {
            $from = $paginate->createdAt;
            $to = $paginate->createdAtTo;
            if($to && $from) {
                $query->whereBetween("created_at", [$from, $to]);
            }else{
                if($from) {
                    $query->whereDate("created_at", ">=", $from);
                }
                if($to){
                    $query->whereDate("created_at", "<=", $to);
                }
            }
        }

        if($paginate->deliveredAt || $paginate->deliveredAtTo) {
            $from = $paginate->deliveredAt;
            $to = $paginate->deliveredAtTo;
            if($to && $from) {
                $query->whereBetween("delivery_at", [$from, $to]);
            }else{
                if($from) {
                    $query->whereDate("delivery_at", "<=", $from);
                }
                if($to){
                    $query->whereDate("delivery_at", ">=", $to);
                }
            }
        }
        if($paginate->search){
            $query->where(function($q) use ($paginate){
                $q->orWhere([
                    ['code', 'like' ,"%{$paginate->search}%"]
                ]);
            });
        }
    }
}