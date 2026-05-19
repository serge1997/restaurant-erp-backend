<?php
namespace App\Modules\RoomType\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\RoomType\RoomTypeResource;
use App\Modules\RoomType\Infra\RoomTypeRepository;

final class RoomTypeListUseCase
{
    public function __construct(
        private readonly RoomTypeRepository $roomTypeRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return RoomTypeResource::collection(
            $this->roomTypeRepository->findAll($paginate)
        );
    }
}