<?php
namespace App\Modules\Alert\UseCases;

use App\Modules\Alert\Infra\Repository\AlertRepository;

final class AlertDeleteUseCase
{
    public function __construct(
        private readonly AlertRepository $alertRepository
    ){}

    public function execute(int $id)
    {

    }

}