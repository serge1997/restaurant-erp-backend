<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PreRegistration\PreRegistrationConfirmRequest;
use App\Http\Requests\PreRegistration\PreRegistrationCreateRequest;
use App\Models\PreRegistration;
use App\Modules\PreRegistration\UseCases\PreRegistrationConfirmUseCase;
use App\Modules\PreRegistration\UseCases\PreRegistrationCreateUseCase;
use App\Modules\PreRegistration\UseCases\PreRegistrationListUseCase;
use App\Modules\PreRegistration\UseCases\PreRegistrationRegenerateConfirmTokenUseCase;
use Illuminate\Http\JsonResponse;

class PreRegistrationController extends BaseApiController
{
    
    public function store(PreRegistrationCreateRequest $request): JsonResponse
    {
        /** @var PreRegistrationCreateUseCase $useCase */
        $useCase = $this->container->get(PreRegistrationCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("cadastro realizado com successo.");
    }

    public function listByToken(string $token): JsonResponse
    {
        /** @var PreRegistrationListUseCase $useCase */
        $useCase = $this->container->get(PreRegistrationListUseCase::class);
        $preRegistration = $useCase->listByToken($token);
        return $this->apiResponse("pre registration by token", $preRegistration);
    }

    public function confirmation(PreRegistrationConfirmRequest $request): JsonResponse
    {
        /** @var PreRegistrationConfirmUseCase $useCase */
        $useCase = $this->container->get(PreRegistrationConfirmUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("cadastro confirmado com successo!");
    }

    public function regenerateConfirmationToken(PreRegistration $preRegistration): JsonResponse
    {
        /** @var PreRegistrationRegenerateConfirmTokenUseCase $useCase */
        $useCase = $this->container->get(PreRegistrationRegenerateConfirmTokenUseCase::class);
        $useCase->execute($preRegistration);
        return $this->apiResponse("token gerado com successo!");
    }
}
