<?php
namespace App\Modules\TechnicalSheet\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\MenuItem;
use App\Models\TechnicalSheet;

class TechnicalSheetRepository extends BaseRepository
{

    public function __construct(
        private readonly TechnicalSheet $model
    ){}

    public function eloquent(): TechnicalSheet
    {
        return app(TechnicalSheet::class);
    }

    public function findByMenuItem(MenuItem $menuItem)
    {
        return $this->model->where("menu_item_id", $menuItem->id)->get();
    }
}