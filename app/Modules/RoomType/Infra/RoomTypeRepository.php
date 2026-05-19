<?php
namespace App\Modules\RoomType\Infra;


use App\Foundation\Base\BaseRepository;
use App\Models\RoomType;

class RoomTypeRepository extends BaseRepository
{
    
    protected function eloquent(): RoomType
    {
        return app(RoomType::class);
    }
}