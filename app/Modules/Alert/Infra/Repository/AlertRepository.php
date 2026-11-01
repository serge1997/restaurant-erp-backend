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

    public function updateOrCreate(array $payload): Alert
    {
        return $this->eloquent()->updateOrCreate([
            'alertable_type'    => $payload['alertable_type'],
            'alertable_id'      => $payload['alertable_id'],
            'severity'          => $payload['severity'],
            'is_resolved'       => false
        ], $payload);
    }
}