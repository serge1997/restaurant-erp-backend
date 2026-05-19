<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Models\User;
use App\Modules\Role\UseCases\RoleListUseCase;

class RoleController extends BaseApiController
{
    
    public function index()
    {
        /** @var RoleListUseCase $useCase */
        $useCase = $this->container->get(RoleListUseCase::class);
        $response = $useCase->execute();
        return $this->apiResponse("listando roles", $response);
    }

    public function listByUser(User $user)
    {
        /** @var RoleListUseCase $useCase */
        $useCase = $this->container->get(RoleListUseCase::class);
        $response = $useCase->listByUser($user);
        return $this->apiResponse("listando roles do usuario", $response);
    }
}
