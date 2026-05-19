<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Modules\Module\UseCases\ModuleListUseCase;

class ModuleController extends BaseApiController
{
    
    public function index()
    {
        /** @var ModuleListUseCase $useCase */
        $useCase = $this->container->get(ModuleListUseCase::class);
        $modules = $useCase->execute();
        return $this->apiResponse("list of modules with permision", $modules);
    }
}
