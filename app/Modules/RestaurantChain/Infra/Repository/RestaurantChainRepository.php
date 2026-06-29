<?php
namespace App\Modules\RestaurantChain\Infra\Repository;


use App\Foundation\Base\BaseRepository;
use App\Models\RestaurantChain;
use Override;

class RestaurantChainRepository extends BaseRepository
{

    #[Override]
    public function eloquent(): RestaurantChain
    {
        return app(RestaurantChain::class);
    }
}