<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Modules\Auth\UseCases\AuthLoginUseCase;
use App\Modules\Auth\UseCases\AuthLogoutUseCase;

class AuthController extends BaseApiController
{
    

    public function login(AuthLoginRequest $request)
    {
        /** @var AuthLoginUseCase $useCase */
        $useCase = $this->container->get(AuthLoginUseCase::class);
        $response = $useCase->execute($request);
        return $this->apiResponse("login realizado com successo", $response);
    }

    public function logout()
    {
        /** @var AuthLogoutUseCase $useCase */
        $useCase = $this->container->get(AuthLogoutUseCase::class);
        $useCase->execute();
        return $this->apiResponse("logout realizado com successo");
    }
}
