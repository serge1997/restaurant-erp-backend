<?php
namespace App\Modules\Reservation\UseCases;

use App\Modules\Reservation\Exceptions\ReservationException;
use App\Modules\Reservation\Infra\Repository\ReservationRepository;

final class ReservationDeleteUseCase
{
    public function __construct(
        private readonly ReservationRepository $reservationRepository
    ){}

    public function execute($id)
    {
        $resvervation = $this->reservationRepository->find($id);
        if(!$resvervation){
            throw ReservationException::notFound();
        }
        $this->reservationRepository->delete($resvervation);
    }
}
