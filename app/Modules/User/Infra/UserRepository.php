<?php
namespace App\Modules\User\Infra;


use App\Foundation\Base\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    protected array $searchableFields = [];

    protected function eloquent(): User
    {
        return app(User::class);
    }
}