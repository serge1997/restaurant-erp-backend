<?php
namespace App\Modules\Supplier\UseCases;

use App\Http\Requests\Supplier\SupplierUpdateRequest;
use App\Modules\Supplier\Exceptions\SupplierNotFountException;
use App\Modules\Supplier\Repository\SupplierRepostory;

final class SupplierUpdateUseCase
{
    public function __construct(
        private readonly SupplierRepostory $supplierRepostory
    ){}

    public function execute(SupplierUpdateRequest $request)
    {
        $payload = $request->validated();
        $supplier = $this->supplierRepostory->find($request->id);
        if (!$supplier) {
            throw new SupplierNotFountException;
        }
        $this->supplierRepostory->update($supplier, $payload);
    }
}