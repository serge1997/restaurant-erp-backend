<?php
namespace App\Modules\PurchaseRequisition\UseCases;


use App\Models\PurchaseRequisition;
use App\Modules\PurchaseRequisition\Repository\PurchaseRequisitionRepository;

final class PurchaseRequisitionDeleteUseCase
{
    public function __construct(
        private PurchaseRequisitionRepository $purchaseRequisitionRepository
    ){}
    
    public function execute(PurchaseRequisition $purchaseRequisition)
    {
        
    }
}