<?php
namespace App\Modules\Alert\UseCases;

use App\Http\Requests\Alert\AlertCreateRequest;
use App\Modules\Alert\Infra\Repository\AlertRepository;

final class AlertCreateUseCase
{
    public function __construct(
        private readonly AlertRepository $alertRepository
    ){}

    public function execute(AlertCreateRequest $request)
    {
        $payload = $request->validated();
        $this->alertRepository->save($payload);
    }

}