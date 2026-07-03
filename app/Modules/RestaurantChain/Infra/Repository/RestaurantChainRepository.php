<?php
namespace App\Modules\RestaurantChain\Infra\Repository;


use App\Foundation\Base\BaseRepository;
use App\Models\RestaurantChain;

class RestaurantChainRepository extends BaseRepository
{
    public function eloquent(): RestaurantChain
    {
        return app(RestaurantChain::class);
    }
}