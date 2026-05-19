<?php
namespace App\Modules\Module\UseCases;

use App\Http\Resources\Module\ModuleResource;
use App\Models\Module;
use App\Modules\Module\Infra\ModuleRepository;

final class ModuleListUseCase
{
    public function __construct(
        private readonly ModuleRepository $repository
    ) {}

    public function execute()
    {
        $response = [];
        $modules = $this->repository->loadMdules();
        $modules->each(function(Module $module) use (&$response) {
            $response[] = [
                "id" => $module->id,
                "name" => $module->name,
                "description" => $module->description,
                "permissions"   
            ];
        });
        return ModuleResource::collection($this->repository->loadMdules());
    }
}