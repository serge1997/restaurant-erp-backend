<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;

class StateController extends BaseApiController
{
    
    public function index(PaginateRequest $request)
    {
        /** @var \App\Modules\Address\UseCases\StateListUseCase $useCase */
        $useCase = $this->container->get(\App\Modules\Address\UseCases\StateListUseCase::class);
        $states = $useCase->execute($request);
        return $this->apiResponse("states list", $states);
    }
}
