<?php
namespace App\Modules\Room\Infra;

use App\Foundation\Base\BaseRepository;
use App\Models\Room;

class RoomRepository extends BaseRepository
{

    public function __construct(
        private Room $model
    ){
        parent::__construct();
    }

    public function eloquent(): Room
    {
       return app(Room::class);
    }

    public function totalCapacity(): int
    {
        return $this->getQuery()->sum("capacity");
    }
}