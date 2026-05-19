<?php
namespace App\Modules\Restaurant\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Restaurant\RestaurantCreateRequest;
use App\Http\Resources\Restaurant\RestaurantResource;
use App\Models\Restaurant;
use App\Modules\Restaurant\Repository\RestaurantRepository;

final class RestaurantListUseCase
{
    public function __construct(
        private readonly RestaurantRepository $restaurantRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return RestaurantResource::collection(
            $this->restaurantRepository->findAll($paginate)
        );
    }

    public function listById(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant);
    }
}