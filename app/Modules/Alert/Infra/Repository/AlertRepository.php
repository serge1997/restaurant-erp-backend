<?php
namespace App\Modules\Alert\Infra\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\Alert;
use Override;

class AlertRepository extends BaseRepository
{

    protected array $searchableFields = ["is_resolved"];

    #[Override]
    protected function eloquent(): Alert
    {
        return app(Alert::class);
    }
}