<?php
namespace App\Foundation\Base;

use App\Models\User;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

abstract class BaseUseCase
{
    public function __construct(
        private readonly BaseRepository $baseRepository
    ){}

    protected function getActivesMetada(): array
    {
        $actives = $this->baseRepository->newQuery()->where("is_active", true)->count();
        $inactive = $this->baseRepository->newQuery()->where("is_active", false)->count();
        return [
            "count_actives" => $actives,
            "count_inactives"   => $inactive
        ];
    }

    protected function totalMetadata(): array
    {
        return [
            "total"  => $this->baseRepository->newQuery()->count()
        ];
    }

    public function auth(): User
    {
        return request()->user();
    }

    public function cropped_image($file, $width, $height)
    {
        return ImageManager::usingDriver(Driver::class)
            ->decode($file)
                ->coverDown($width, $height);
    }
}