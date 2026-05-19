<?php
namespace App\Modules\Address\Infra;


use App\Foundation\Base\BaseRepository;
use App\Models\Address;

class AddressRepository extends BaseRepository
{

    public function eloquent(): Address
    {
        return new Address();
    }
}