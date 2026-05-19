<?php
declare(strict_types=1);

namespace App\Modules\Restaurant\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\Restaurant;

class RestaurantRepository extends BaseRepository
{

    protected array $searchableFields = [
        "name", 
        "corporate_name"
    ];
    public function __construct(
        private readonly Restaurant $model
    ){
        parent::__construct();
    }

    public function eloquent(): Restaurant
    {
        return app(Restaurant::class);
    }
}