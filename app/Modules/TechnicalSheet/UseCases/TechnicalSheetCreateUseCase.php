<?php
namespace App\Modules\TechnicalSheet\UseCases;

use App\Http\Requests\TechnicalSheet\TechnicalSheetCreateRequest;
use App\Modules\MenuItem\Exceptions\MenuItemNotFountException;
use App\Modules\MenuItem\Repository\MenuItemRepository;
use App\Modules\TechnicalSheet\Exceptions\TecnhicalSheetException;
use App\Modules\TechnicalSheet\Repository\TechnicalSheetRepository;

class TechnicalSheetCreateUseCase
{
    public function __construct(
        private TechnicalSheetRepository $technicalSheetRepository,
        private readonly MenuItemRepository $menuItemRepository
    ){}

    public function execute(TechnicalSheetCreateRequest $request)
    {
        $payload = $request->validated();
        $menuItem = $this->menuItemRepository->find($payload['menu_item_id']);
        if (!$menuItem){
            throw new MenuItemNotFountException;
        }
        $sheet = $this->technicalSheetRepository->findByMenuItem($menuItem);
        if (!$sheet->isEmpty()){
            throw new TecnhicalSheetException("Ficha tecnica já existe");
        }
        $this->technicalSheetRepository->saveMany($payload['products']);
    }
}