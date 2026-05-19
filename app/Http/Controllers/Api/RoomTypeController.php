<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Modules\RoomType\UseCases\RoomTypeListUseCase;

class RoomTypeController extends BaseApiController
{
    
    public function index(PaginateRequest $paginte)
    {
        /** @var RoomTypeListUseCase $useCase */
        $useCase = $this->container->get(RoomTypeListUseCase::class);
        $response = $useCase->execute($paginte);
        return $this->apiResponse("list of room types", $response);
    }
}
