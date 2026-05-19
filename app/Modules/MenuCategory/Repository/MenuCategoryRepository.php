<?php
namespace App\Modules\MenuCategory\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\MenuCategory;

class MenuCategoryRepository extends BaseRepository
{

    protected array $searchableFields = [
        "name",
        "description"
    ];
    public function __construct(
        private readonly MenuCategory $menuCategory
    ){
        parent::__construct();
    }

    protected function eloquent(): MenuCategory
    {
        return app(MenuCategory::class);
    }
}