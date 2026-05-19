<?php
namespace App\Modules\TechnicalSheet\UseCases;

use App\Http\Resources\TechnicalSheet\TechnicalSheetResource;
use App\Models\MenuItem;
use App\Modules\TechnicalSheet\Repository\TechnicalSheetRepository;

final class TecnhicalSheetListUseCase
{
    public function __construct(
        private TechnicalSheetRepository $technicalSheetRepository
    ){}

    public function listByMenuItem(MenuItem $menuItem)
    {
        return TechnicalSheetResource::collection(
            $this->technicalSheetRepository->findByMenuItem($menuItem)
        );
    }
}