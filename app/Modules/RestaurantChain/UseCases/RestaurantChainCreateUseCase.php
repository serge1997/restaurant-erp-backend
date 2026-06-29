<?php
namespace App\Modules\RestaurantChain\UseCases;

use App\Http\Requests\RestaurantChain\RestaurantChainCreateRequest;
use App\Modules\RestaurantChain\Infra\Repository\RestaurantChainRepository;

final class RestaurantChainCreateUseCase
{
    public function __construct(
        private readonly RestaurantChainRepository $restaurantChainRepository
    ){}

    public function execute(RestaurantChainCreateRequest $request)
    {
        $payload = $request->validated();
        $this->restaurantChainRepository->save($payload);
    }
}