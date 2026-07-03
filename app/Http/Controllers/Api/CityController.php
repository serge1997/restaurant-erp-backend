<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use Illuminate\Http\Request;

class CityController extends BaseApiController
{
    
    public function index(PaginateRequest $request)
    {
        /** @var \App\Modules\City\UseCases\CityListUseCase $useCase */
        $useCase = $this->container->get(\App\Modules\City\UseCases\CityListUseCase::class);
        $cities = $useCase->execute($request);
        return $this->apiResponse("cities list", $cities);
    }

    public function indexByState(string $uf)
    {
        /** @var \App\Modules\City\UseCases\CityListUseCase $useCase */
        $useCase = $this->container->get(\App\Modules\City\UseCases\CityListUseCase::class);
        $cities = $useCase->executeByState($uf);
        return $this->apiResponse("cities list by state", $cities);
    }
}
