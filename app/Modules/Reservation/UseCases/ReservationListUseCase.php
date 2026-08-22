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
        return ReservationResource::collection(
            $this->reservationRepository->findAll($paginate)
        );
    }

    public function listById(int $id)
    {
        return new ReservationResource(
            $this->reservationRepository->find($id)
        );
    }
}
