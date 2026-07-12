<?php
namespace App\Modules\PreRegistration\UseCases;

use App\Http\Requests\PreRegistration\PreRegistrationCreateRequest;
use App\Modules\PreRegistration\Exception\PreRegistrationException;
use App\Modules\PreRegistration\Infra\Repository\PreRegistrationRepository;

final class PreRegistrationCreateUseCase
{

    public function __construct(
        private readonly PreRegistrationRepository $preRegistrationRepository
    ){}

    public function execute(PreRegistrationCreateRequest $request)
    {
        $payload = $request->validated();
        $existsByEmail = $this->preRegistrationRepository->existBy("email", $payload["email"]);
        if($existsByEmail){
            throw PreRegistrationException::existsByEmail();
        }
        $existsByCnpj = $this->preRegistrationRepository->existBy("cnpj", $payload["cnpj"]);
        if($existsByCnpj){
            throw PreRegistrationException::existsByCnpj();
        }
    }
}