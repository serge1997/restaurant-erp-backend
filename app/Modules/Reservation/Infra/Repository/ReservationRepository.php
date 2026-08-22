<?php
namespace App\Modules\Reservation\Infra\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\Reservation;

class ReservationRepository extends BaseRepository
{

    protected function eloquent(): Reservation
    {
        return app(Reservation::class);
    }
}
