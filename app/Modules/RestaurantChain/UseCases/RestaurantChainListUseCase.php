<?php
namespace App\Modules\RestaurantChain\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\RestaurantChain\RestaurantChainResource;
use App\Models\RestaurantChain;
use App\Modules\RestaurantChain\Infra\Repository\RestaurantChainRepository;

final class RestaurantChainListUseCase
{
    public function __construct(
        private readonly RestaurantChainRepository $restaurantChainRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return RestaurantChainResource::collection(
            $this->restaurantChainRepository->findAll($paginate)
        );
    }

    public function listById(RestaurantChain $restaurantChain)
    {
        return new RestaurantChainResource($restaurantChain);
    }
}