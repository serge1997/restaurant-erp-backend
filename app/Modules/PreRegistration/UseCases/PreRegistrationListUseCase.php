<?php
namespace App\Modules\PreRegistration\UseCases;

use App\Http\Resources\PreRegistration\PreRegistrationResource;
use App\Models\PreRegistration;
use App\Modules\PreRegistration\Infra\Repository\PreRegistrationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class PreRegistrationListUseCase
{
    public function __construct(
        private readonly PreRegistrationRepository $preRegistrationRepository
    ){}

    public function listByToken(string $token)
    {
        $preRegistration = $this->preRegistrationRepository->findFirstBy(['confirmation_token'], [$token]);
        if ($preRegistration instanceof PreRegistration){
            return new PreRegistrationResource($preRegistration);
        }
        throw new ModelNotFoundException("url de confirmaçao invalido ou nao encontrado.", 404);
    }
}