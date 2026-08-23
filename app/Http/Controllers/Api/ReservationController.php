<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Reservation\ReservationCreateRequest;
use App\Http\Requests\Reservation\ReservationUpdateRequest;

class ReservationController extends BaseApiController
{

    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\Reservation\UseCases\ReservationListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Reservation\UseCases\ReservationListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of reservations", $result);
    }

    public function show(int $id)
    {
        /**  @var \App\Modules\Reservation\UseCases\ReservationListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Reservation\UseCases\ReservationListUseCase::class);
        $result = $useCase->listById($id);
        return $this->apiResponse("showing a reservation", $result);
    }

    public function store(ReservationCreateRequest $request)
    {
        /**  @var \App\Modules\Reservation\UseCases\ReservationCreateUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Reservation\UseCases\ReservationCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "reservaçao criada com successo", status: 201);
    }

    public function update(ReservationUpdateRequest $request)
    {
        /**  @var \App\Modules\Reservation\UseCases\ReservationUpdateUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Reservation\UseCases\ReservationUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "reservaçao alterado com successo", status: 200);
    }

    public function delete(int $id)
    {
        /**  @var \App\Modules\Reservation\UseCases\ReservationDeleteUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Reservation\UseCases\ReservationDeleteUseCase::class);
        $useCase->execute($id);
        return $this->apiResponse(message: "reserva removida com successo", status: 200);
    }

}
