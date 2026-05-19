<?php
namespace App\Modules\Room\UseCases;

use App\Foundation\Base\BaseUseCase;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Room\RoomResource;
use App\Models\Room;
use App\Modules\Room\Infra\RoomRepository;

final class RoomListUseCase extends BaseUseCase
{
    public function __construct(
        private readonly RoomRepository $roomRepository
    )
    {
        parent::__construct($roomRepository);
    }

    public function execute(PaginateRequest $paginte)
    {
        return RoomResource::collection(
            $this->roomRepository->findAll($paginte)
        )->additional(array_merge(
            $this->getActivesMetada(), 
            $this->totalMetadata(),
            [
                "capacity"  => $this->roomRepository->totalCapacity()
            ]
        ));
    }

    public function listById(Room $room)
    {
        return new RoomResource($room);
    }
}