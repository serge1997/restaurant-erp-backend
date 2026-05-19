<?php
namespace App\Modules\Room\UseCases;

use App\Http\Requests\Room\RoomUpdateRequest;
use App\Modules\Room\Exceptions\RoomException;
use App\Modules\Room\Infra\RoomRepository;

final class RoomUpdateUseCase
{
    public function __construct(
        private RoomRepository $roomRepository
    ){}

    public function execute(RoomUpdateRequest $request)
    {
        $payload = $request->validated();
        $room = $this->roomRepository->find($payload['id']);
        if (!$room){
            throw new RoomException("Sala nao encontrada", 404);
        }
        $room_name_exists = $this->roomRepository->findBy(["name", "id:not"], $payload["name"], $room->id);
        if ($room_name_exists){
            throw new RoomException("Já uma sala com esse nome.", 400);
        }
        $this->roomRepository->update($room, $payload);
    }
}