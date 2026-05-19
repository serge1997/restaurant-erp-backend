<?php
namespace App\Modules\Room\UseCases;

use App\Http\Requests\Room\RoomCreateRequest;
use App\Modules\Room\Exceptions\RoomException;
use App\Modules\Room\Infra\RoomRepository;

final class RoomCreateUseCase
{
    public function __construct(
        private readonly RoomRepository $roomRepository
    ){}

    public function execute(RoomCreateRequest $request)
    {
        $payload = $request->validated();
        $room_name_exists = $this->roomRepository->findBy(["name"], $payload['name']);
        if(!empty($room_name_exists)){
            throw new RoomException("Já existe uma sala com esse nome", 400);
        }
        $this->roomRepository->save($payload);
    }
}