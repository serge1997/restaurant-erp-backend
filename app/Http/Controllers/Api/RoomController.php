<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Room\RoomUpdateRequest;
use App\Http\Requests\Room\RoomCreateRequest;
use App\Models\Room;

class RoomController extends BaseApiController
{
    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\Room\UseCases\RoomListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Room\UseCases\RoomListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of rooms", $result);
    }

    public function show(Room $room)
    {
        /**  @var \App\Modules\Room\UseCases\RoomListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Room\UseCases\RoomListUseCase::class);
        $result = $useCase->listById($room);
        return $this->apiResponse("showing a room", $result);
    }

    public function store(RoomCreateRequest $request)
    {
        /**  @var \App\Modules\Room\UseCases\RoomCreateUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Room\UseCases\RoomCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "sala criada com successo", status: 201);
    }

    public function update(RoomUpdateRequest $request)
    {
        /**  @var \App\Modules\Room\UseCases\RoomUpdateUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Room\UseCases\RoomUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "sala alterado com successo", status: 200);
    }

    public function delete(int $id)
    {
        /**  @var \App\Modules\Room\UseCases\RoomDeleteUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Room\UseCases\RoomDeleteUseCase::class);
        $useCase->execute($id);
        return $this->apiResponse(message: "sala removida com successo", status: 200);
    }

}
