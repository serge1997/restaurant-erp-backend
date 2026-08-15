<?php
namespace App\Modules\Alert\UseCases;

use App\Http\Requests\Alert\AlertUpdateRequest;
use App\Modules\Alert\Infra\Repository\AlertRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class AlertUpdateUseCase
{
    public function __construct(
        private readonly AlertRepository $alertRepository
    ){}

    public function execute(AlertUpdateRequest $request)
    {
        $payload = $request->validated();
        $alert = $this->alertRepository->find($payload['id']);
        if(!$alert){
            throw new ModelNotFoundException();
        }
        $this->alertRepository->update($alert, $payload);
    }
}