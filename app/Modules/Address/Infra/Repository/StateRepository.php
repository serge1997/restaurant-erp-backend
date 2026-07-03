<?php
namespace App\Modules\Address\Infra\Repository;
use App\Foundation\Base\BaseRepository;
use App\Models\State;

class StateRepository extends BaseRepository
{

    public function eloquent(): State
    {
        return new State();
    }
}