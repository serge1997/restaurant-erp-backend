<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\StockMovment\StockMovmentCreateRequest;
use App\Http\Requests\StockMovment\StockMovmentUpdateRequest;
use App\Models\Product;
use App\Models\StockMovment;
use App\Modules\StockMovment\UseCases\StockMovmentCreateUseCase;
use App\Modules\StockMovment\UseCases\StockMovmentListUseCase;
use App\Modules\StockMovment\UseCases\StockMovmentUpdateUseCase;
use Illuminate\Http\JsonResponse;

class StockMovmentController extends BaseApiController
{

    public function index(PaginateRequest $paginate)
    {
        /** @var StockMovmentListUseCase $useCase */
        $useCase = $this->container->get(StockMovmentListUseCase::class);
        $response = $useCase->execute($paginate);
        return $this->apiResponse("listando movimentaçao de estoque", $response);
    }

    public function store(StockMovmentCreateRequest $request)
    {
        /** @var StockMovmentCreateUseCase $useCase */
        $useCase = $this->container->get(StockMovmentCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "movimentaçao de estoque criado com successo", status: 201);
    }

    public function show(StockMovment $stockMovment)
    {
        /** @var StockMovmentListUseCase $useCase */
        $useCase = $this->container->get(StockMovmentListUseCase::class);
        $response = $useCase->listById($stockMovment);
        return $this->apiResponse("mostrando movimentaçao de estoque.", $response);
    }

    public function update(StockMovmentUpdateRequest $request)
    {
        /** @var StockMovmentUpdateUseCase $useCase */
        $useCase = $this->container->get(StockMovmentUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("movimentaçao de estoque alterado com sucesso.");
    }

    public function listLastProduct(Product $product): JsonResponse
    {
        /** @var StockMovmentListUseCase $useCase */
        $useCase = $this->container->get(StockMovmentListUseCase::class);
        $response = $useCase->listLastProduct($product);
        return $this->apiResponse("list last movement of product", $response);
    }
}
