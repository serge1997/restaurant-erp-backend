<?php
namespace App\Modules\Supplier\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Supplier\SupplierResource;
use App\Models\Supplier;
use App\Modules\Supplier\Repository\SupplierRepostory;

final class SupplierListUseCase
{
    public function __construct(
        private readonly SupplierRepostory $supplierRepostory
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return SupplierResource::collection(
            $this->supplierRepostory->findAll($paginate)
        );
    }

    public function listById(Supplier $supplier)
    {
        return new SupplierResource($supplier);
    }
}