<?php
namespace App\Modules\Module\Infra;

use App\Models\Module;

class ModuleRepository
{
    public function __construct(
        private readonly Module $model
    ){}
    
    public function loadMdules()
    {
        return $this->model->query()->get();
    }
}