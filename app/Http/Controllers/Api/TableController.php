<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Table\TableCreateRequest;
use App\Http\Requests\Table\TableUpdateRequest;
use App\Models\Table;
use App\Modules\Table\UseCases\TableCreateUseCase;
use App\Modules\Table\UseCases\TableListUseCase;
use App\Modules\Table\UseCases\TableUpdateUseCase;

class TableController extends BaseApiController
{

    public function index(PaginateRequest $paginate)
    {
        /** @var TableListUseCase $useCase */
        $useCase = $this->container->get(TableListUseCase::class);
        $response = $useCase->execute($paginate);
        return $this->apiResponse("list restaurants tables", $response);
    }
    
    public function store(TableCreateRequest $request)
    {
        /** @var TableCreateUseCase $useCase */
        $useCase = $this->container->get(TableCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("Mesa criada com sucesso");
    }

    public function show(Table $table)
    {
        /** @var TableListUseCase $useCase */
        $useCase = $this->container->get(TableListUseCase::class);
        $response = $useCase->listById($table);
        return $this->apiResponse("showing table", $response);
    }

    public function update(TableUpdateRequest $request)
    {
        /**  @var TableUpdateUseCase $useCase  */
        $useCase = $this->container->get(TableUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "mesa alterado com successo", status: 200);
    }

    public function delete(int $id)
    {
        /**  @var \App\Modules\Table\UseCases\TableDeleteUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Table\UseCases\TableDeleteUseCase::class);
        $useCase->execute($id);
        return $this->apiResponse(message: "mesa removida com successo", status: 200);
    }

    public function listForOrders()
    {
        /**  @var TableListUseCase $useCase  */
        $useCase = $this->container->get(TableListUseCase::class);
        $response = $useCase->listForOrders();
        return $this->apiResponse("list tables for orders", $response);
    }
}
