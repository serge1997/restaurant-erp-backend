<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Models\RestaurantChain;
use App\Http\Requests\RestaurantChain\RestaurantChainCreateRequest;
use App\Http\Requests\RestaurantChain\RestaurantChainUpdateRequest;

class RestaurantChainController extends BaseApiController
{
    
    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\RestaurantChain\UseCases\RestaurantChainListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\RestaurantChain\UseCases\RestaurantChainListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of restaurants chain", $result);
    }

    public function show(RestaurantChain $restaurantChain)
    {
        /**  @var \App\Modules\RestaurantChain\UseCases\RestaurantChainListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\RestaurantChain\UseCases\RestaurantChainListUseCase::class);
        $result = $useCase->listById($restaurantChain);
        return $this->apiResponse("showing a restaurants chain", $result);
    }

    public function store(RestaurantChainCreateRequest $request)
    {
        /**  @var \App\Modules\RestaurantChain\UseCases\RestaurantChainCreateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\RestaurantChain\UseCases\RestaurantChainCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "rede de restaurantes criado com successo", status: 201);
    }

    public function update(RestaurantChainUpdateRequest $request)
    {
        /**  @var \App\Modules\RestaurantChain\UseCases\RestaurantChainUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\RestaurantChain\UseCases\RestaurantChainUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "rede de restaurantes alterado com successo", status: 200);
    }
}
