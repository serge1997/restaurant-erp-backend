<?php
namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Supplier\SupplierCreateRequest;
use App\Http\Requests\Supplier\SupplierUpdateRequest;
use App\Models\Supplier;
use App\Modules\Supplier\UseCases\SupplierListUseCase;

class SupplierController extends BaseApiController
{

    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\Supplier\UseCases\SupplierListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Supplier\UseCases\SupplierListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of fornecedor", $result);
    }

    public function show(Supplier $supplier)
    {
        /**  @var \App\Modules\Supplier\UseCases\SupplierListUseCase $useCse  */
        $useCase = $this->container->get(SupplierListUseCase::class);
        $result = $useCase->listById($supplier);
        return $this->apiResponse("showing a supplier", $result);
    }

    public function store(SupplierCreateRequest $request)
    {
        /**  @var \App\Modules\Supplier\UseCases\SupplierCreateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Supplier\UseCases\SupplierCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "fornecedor criado com successo", status: 201);
    }

    public function update(SupplierUpdateRequest $request)
    {
        /**  @var \App\Modules\Supplier\UseCases\SupplierUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Supplier\UseCases\SupplierUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "fornecedor alterado com successo", status: 200);
    }

}
