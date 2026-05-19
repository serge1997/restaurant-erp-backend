<?php
namespace App\Modules\Supplier\UseCases;

use App\Models\Supplier;
use App\Modules\Supplier\Repository\SupplierRepostory;

final class SupplierDeleteUseCase
{
    public function __construct(
        private readonly SupplierRepostory $supplierRepostory
    ){}

    public function execute(Supplier $supplier)
    {
        $this->supplierRepostory->delete($supplier);
    }
}