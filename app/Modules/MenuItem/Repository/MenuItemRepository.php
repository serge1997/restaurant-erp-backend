<?php
namespace App\Modules\MenuItem\Repository;


use App\Foundation\Base\BaseRepository;
use App\Http\Requests\PaginateRequest;
use App\Models\MenuItem;

class MenuItemRepository extends BaseRepository
{
    protected array $searchableFields = [
        "id",
        "name",
        "category_id"
    ];
    public function __construct()
    {
        return parent::__construct();
    }

    public function eloquent(): MenuItem
    {
        return app(MenuItem::class);
    }

    public function findAll(?PaginateRequest $paginate = null)
    {
        $query = $this->getQuery();
        if (!empty($paginate->categories)) {
            $query->whereIn("category_id", $paginate->categories);
        }
        if ($paginate->features){
            $query->where("featured_types", "LIKE" ,"%". implode(",", $paginate->features) . "%");
        }
        if($paginate->cooking_time_max){
            $cooking_time_max = "00:{$paginate->cooking_time_max}:00";
            $query->whereRaw("cooking_time <= '{$cooking_time_max}'");
        }
        if($paginate->ids){
            $query->whereIn("id", $paginate->ids);
        }
        return parent::findAll($paginate);
    }

    public function findtopOrdered()
    {
        $query = $this->newQuery();
        $query->selectRaw("menu_items.id, count(o.menu_item_id)")
            ->join("order_items as o", "o.menu_item_id", "=", "menu_items.id")
                ->groupBy("menu_items.id")
                    ->orderByRaw("count(o.menu_item_id) desc");
        return $query;
    }
}