<?php
namespace App\Modules\Address\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Modules\Address\Infra\Repository\StateRepository;

final class StateListUseCase
{
    public function __construct(
        private readonly StateRepository $stateRepository
    ){}

    public function execute(PaginateRequest $request)
    {
        return $this->stateRepository->findAll($request);
    }
}