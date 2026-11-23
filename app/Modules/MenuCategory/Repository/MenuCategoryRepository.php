<?php
namespace App\Modules\MenuCategory\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\MenuCategory;
use Illuminate\Support\Facades\DB;

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

    public function findTopCategories()
    {
        $query = DB::table("menu_items as i")->selectRaw("
            i.category_id, count(o.menu_item_id)
        ")
            ->join("order_items as o", "o.menu_item_id", "=", "i.id")
                ->groupByRaw("i.category_id")
                    ->orderByRaw("count(o.menu_item_id) desc");
        return $query;
    }
}