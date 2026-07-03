<?php
namespace App\Modules\RestaurantChain\UseCases;

use App\Http\Requests\RestaurantChain\RestaurantChainCreateRequest;
use App\Models\RestaurantChain;
use App\Modules\RestaurantChain\Infra\Repository\RestaurantChainRepository;
use Illuminate\Support\Facades\DB;

final class RestaurantChainCreateUseCase
{
    public function __construct(
        private readonly RestaurantChainRepository $restaurantChainRepository,
    ){}

    public function execute(RestaurantChainCreateRequest $request)
    {
        $payload = $request->validated();
        DB::transaction(function() use($payload){
            $chain = $this->restaurantChainRepository->save($payload);
            $chain->address()->create([
                ...$payload['address'],
                "model" => RestaurantChain::class
            ]);
        });
    }
}