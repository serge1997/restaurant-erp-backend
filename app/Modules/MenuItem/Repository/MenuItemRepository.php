<?php
namespace App\Modules\MenuItem\Repository;


use App\Foundation\Base\BaseRepository;
use App\Http\Requests\PaginateRequest;
use App\Models\MenuItem;

class MenuItemRepository extends BaseRepository
{
    protected array $searchableFields = [
        "id",
        "name"
    ];
    public function __construct()
    {
        return parent::__construct();
    }

    public function eloquent(): MenuItem
    {
        return app(MenuItem::class);
    }

    public function findAll(PaginateRequest $paginate)
    {
        if ($paginate->categories) {
            $this->getQuery()->whereIn("category_id", $paginate->categories);
        }
        if ($paginate->features){
            $this->getQuery()->where("featured_types", "LIKE" ,"%". implode(",", $paginate->features) . "%");
        }
        return parent::findAll($paginate);
    }
}