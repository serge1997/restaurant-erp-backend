<?php
namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Restaurant\RestaurantCreateRequest;
use App\Http\Requests\Restaurant\RestaurantUpdateRequest;
use App\Models\Restaurant;

class RestaurantController extends BaseApiController
{

    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\Restaurant\UseCases\RestaurantListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Restaurant\UseCases\RestaurantListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of restaurants", $result);
    }

    public function show(Restaurant $restaurant)
    {
        /**  @var \App\Modules\Restaurant\UseCases\RestaurantListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Restaurant\UseCases\RestaurantListUseCase::class);
        $result = $useCase->listById($restaurant);
        return $this->apiResponse("showing a restaurant", $result);
    }

    public function store(RestaurantCreateRequest $request)
    {
        /**  @var \App\Modules\Restaurant\UseCases\RestaurantCreateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Restaurant\UseCases\RestaurantCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "restaurant criado com successo", status: 201);
    }

    public function update(RestaurantUpdateRequest $request)
    {
        /**  @var \App\Modules\Restaurant\UseCases\RestaurantUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Restaurant\UseCases\RestaurantUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "restaurant alterado com successo", status: 200);
    }

}
