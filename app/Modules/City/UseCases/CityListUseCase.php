<?php
namespace App\Modules\City\UseCases;

use App\Modules\City\Infra\Repository\CityRepository;
final class CityListUseCase
{
    public function __construct(
        private readonly CityRepository $cityRepository
    ){}

    public function execute(\App\Http\Requests\PaginateRequest $request)
    {
        return $this->cityRepository->findAll($request);
    }

    public function executeByState(string $uf)
    {
        return $this->cityRepository->findBy(['uf'], [$uf]);
    }
}