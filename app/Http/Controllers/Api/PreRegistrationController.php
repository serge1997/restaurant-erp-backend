<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PreRegistration\PreRegistrationCreateRequest;
use App\Modules\PreRegistration\UseCases\PreRegistrationCreateUseCase;

class PreRegistrationController extends BaseApiController
{
    
    public function store(PreRegistrationCreateRequest $request)
    {
        /** @var PreRegistrationCreateUseCase $useCase */
        $useCase = $this->container->get(PreRegistrationCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("cadastro realizado com successo.");
    }
}
