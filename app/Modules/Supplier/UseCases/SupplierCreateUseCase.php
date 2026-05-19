<?php
namespace App\Modules\Supplier\UseCases;

use App\Http\Requests\Supplier\SupplierCreateRequest;
use App\Modules\Supplier\Repository\SupplierRepostory;

final class SupplierCreateUseCase
{
    public function __construct(
        private readonly SupplierRepostory $supplierRepostory
    ){}

    public function execute(SupplierCreateRequest $request)
    {
        $this->supplierRepostory->save($request->validated());
    }
}