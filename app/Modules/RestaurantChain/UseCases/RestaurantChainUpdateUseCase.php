<?php
namespace App\Modules\RestaurantChain\UseCases;

use App\Http\Requests\RestaurantChain\RestaurantChainUpdateRequest;
use App\Modules\RestaurantChain\Exceptions\RestaurantChainException;
use App\Modules\RestaurantChain\Infra\Repository\RestaurantChainRepository;

final class RestaurantChainUpdateUseCase
{
    public function __construct(
        private readonly RestaurantChainRepository $restaurantChainRepository
    ){}

    public function execute(RestaurantChainUpdateRequest $request)
    {
        $payload = $request->validated();
        $restaurantChain = $this->restaurantChainRepository->find($request->id);
        if(!$restaurantChain){
            throw RestaurantChainException::notFound();
        }
        $this->restaurantChainRepository->update($restaurantChain, $payload);
    }
}