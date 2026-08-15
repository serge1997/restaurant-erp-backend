<?php
namespace App\Modules\Alert\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Alert\AlertResource;
use App\Models\Alert;
use App\Modules\Alert\Infra\Repository\AlertRepository;

final class AlertListUseCase
{
    public function __construct(
        private readonly AlertRepository $alertRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return AlertResource::collection(
            $this->alertRepository->findAll($paginate)
        );
    }

    public function listById(Alert $alert)
    {
        return new AlertResource($alert);
    }
}