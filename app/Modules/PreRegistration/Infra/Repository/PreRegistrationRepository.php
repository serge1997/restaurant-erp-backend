<?php
namespace App\Modules\PreRegistration\Infra\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\PreRegistration;
use Override;

class PreRegistrationRepository extends BaseRepository
{

    #[Override]
    protected function eloquent(): PreRegistration
    {
        return app(PreRegistration::class);
    }
}