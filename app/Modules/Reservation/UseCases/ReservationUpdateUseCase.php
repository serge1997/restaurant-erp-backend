<?php
namespace App\Modules\Reservation\UseCases;

use App\Http\Requests\Reservation\ReservationCreateRequest;
use App\Http\Requests\Reservation\ReservationUpdateRequest;
use App\Models\Reservation;
use App\Models\Table;
use App\Modules\Reservation\Exceptions\ReservationException;
use App\Modules\Reservation\Infra\Repository\ReservationRepository;
use App\Modules\Table\Exceptions\TableException;
use App\Modules\Table\Repository\TableRepository;

final class ReservationUpdateUseCase
{
    public function __construct(
        private readonly ReservationRepository $reservationRepository,
        private readonly TableRepository $tableRepository
    ){}

    public function execute(ReservationUpdateRequest $request)
    {
        $payload = $request->validated();
        /** @var Reservation $reservation */
        $reservation = $this->reservationRepository->find($payload["id"]);
        if(!$reservation){
            throw ReservationException::notFound();
        }
        /** @var Table $table */
        $table = $this->tableRepository->find($payload['table_id']);
        if(!$table){
            throw new TableException("mesa nao encontrada", 404);
        }
        if(!$table->is($reservation->table)){
             if($table->hasOpenningReservation()){
                 throw new ReservationException("A mesa selecionada está com uma reserva aberta", 400);
             }
        }
        $this->reservationRepository->save($payload);
    }
}
