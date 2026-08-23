<?php
namespace App\Modules\Reservation\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Reservation\ReservationResource;
use App\Modules\Reservation\Infra\Repository\ReservationRepository;

final class ReservationListUseCase
{

    public function __construct(
        private readonly ReservationRepository $reservationRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        $collection = ReservationResource::collection(
            $this->reservationRepository->findAll($paginate)
        );
        return $collection->collection->groupBy(fn($res) => explode(':', $res->hour)[0]);
    }

    public function listById(int $id)
    {
        return new ReservationResource(
            $this->reservationRepository->find($id)
        );
    }
}
