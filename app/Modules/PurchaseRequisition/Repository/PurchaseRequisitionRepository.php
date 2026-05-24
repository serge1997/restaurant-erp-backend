<?php
namespace App\Modules\PurchaseRequisition\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\PurchaseRequisition;
use App\Modules\PurchaseRequisition\Enums\PurchaseRequisitionStatusEnum;

class PurchaseRequisitionRepository extends BaseRepository
{
    protected array $searchableFields = [];

    public function __construct(
        private PurchaseRequisition $purchaseRequisition
    ){
        parent::__construct();
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
}