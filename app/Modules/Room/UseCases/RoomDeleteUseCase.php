<?php
namespace App\Modules\Room\UseCases;

use App\Modules\Room\Exceptions\RoomException;
use App\Modules\Room\Infra\RoomRepository;

final class RoomDeleteUseCase
{
    public function __construct(
        private readonly RoomRepository $roomRepository
    ){}

    public function execute(int $id)
    {
        $room = $this->roomRepository->find($id);
        if (!$room){
            throw new RoomException("Sala nao encontrada", 404);
        }
        $this->roomRepository->delete($room);
    }
}