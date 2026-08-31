<?php
namespace App\Modules\Reservation\Infra\Repository;

use App\Foundation\Base\BaseRepository;
use App\Http\Requests\PaginateRequest;
use App\Models\Reservation;
use App\Modules\Reservation\Infra\Filters\ReservationFilter;

class ReservationRepository extends BaseRepository
{

    protected function eloquent(): Reservation
    {
        return app(Reservation::class);
    }

    public function findAll(?PaginateRequest $paginate = null)
    {
        $query = $this->getQuery();
        $filter = new ReservationFilter($paginate);
        $filter->apply($query);
        return parent::findAll($paginate);
    }
}
