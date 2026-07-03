<?php
namespace App\Modules\City\Infra\Repository;

use App\Foundation\Base\BaseRepository;
use App\Models\City;

class CityRepository extends BaseRepository
{

    public function findOrCreate(array $attributes): City
    {
        $exists = $this->eloquent()->where([
            ['uf', $attributes['uf']],
            ['name', $attributes['name']]
        ])->first();
        if ($exists) {
            return $exists;
        }
        return parent::save($attributes);
    }
    protected function eloquent(): \Illuminate\Database\Eloquent\Model
    {
        return new \App\Models\City();
    }
}