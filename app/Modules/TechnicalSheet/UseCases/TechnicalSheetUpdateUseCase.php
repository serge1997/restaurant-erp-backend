<?php
namespace App\Modules\TechnicalSheet\UseCases;

use App\Http\Requests\TechnicalSheet\TechnicalSheetUpdateRequest;
use App\Models\TechnicalSheet;
use App\Modules\MenuItem\Exceptions\MenuItemNotFountException;
use App\Modules\MenuItem\Repository\MenuItemRepository;
use App\Modules\TechnicalSheet\Exceptions\TecnhicalSheetException;
use App\Modules\TechnicalSheet\Repository\TechnicalSheetRepository;

final class TechnicalSheetUpdateUseCase
{
    public function __construct(
        private readonly TechnicalSheetRepository $technicalSheetRepository,
        private readonly MenuItemRepository $menuItemRepository
    ){}

    public function execute(TechnicalSheetUpdateRequest $request)
    {
        $payload = $request->validated();
        $menuItem = $this->menuItemRepository->find($payload['menu_item_id']);
        if (!$menuItem){
            throw new MenuItemNotFountException;
        }
        $sheet = $this->technicalSheetRepository->findByMenuItem($menuItem);
        if (!$sheet) {
            throw new TecnhicalSheetException("Ficha tecnica nao encontrada", 400);
        }
        $product_ids = array_column($payload['products'], "product_id");
        $sheet->each(function(TechnicalSheet $technicalSheet) use($product_ids) {
            if (!in_array($technicalSheet->product_id, $product_ids)) {
                $technicalSheet->delete();
            }
        });
        $toSave = [];
        foreach($payload["products"] as $product) {
            if (isset($product["id"]) && !blank($product["id"])) {
                $technicalSheet = $this->technicalSheetRepository->find($product["id"]);
                $this->technicalSheetRepository->update($technicalSheet, $product);
                continue;
            }
            $toSave[] = $product;
        }
        $this->technicalSheetRepository->saveMany($toSave);
    }
}