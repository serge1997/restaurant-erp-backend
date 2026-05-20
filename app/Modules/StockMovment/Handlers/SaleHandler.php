<?php
namespace App\Modules\StockMovment\Handlers;

use App\Models\Product;
use App\Foundation\Base\BaseModel;
use App\Models\OrderItem;
use App\Models\TechnicalSheet;
use App\Modules\StockMovment\Enums\StockMovmentDirectionEnum;
use App\Modules\StockMovment\Exceptions\StockMovementException;
use App\Modules\StockMovment\Handlers\Contracts\StockMovmentHandlerInterface;
use App\Modules\StockMovment\Repository\StockMovmentRepository;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;

class SaleHandler implements StockMovmentHandlerInterface
{
    public function __construct(
        private readonly StockMovmentRepository $stockMovmentRepository
    ){}
    public function handle(?BaseModel $reference, array $payload, ?Product $product = null)
    {
        $menuItemSheets = [];
        $itensQuantities = [];
        $payloadItems = $payload['items'];
        $payloadMenuItemIds = array_column($payloadItems, 'menu_item_id');
        $payloadQuantities = array_column($payloadItems, 'quantity');
        $reference->refresh();
        $reference->items->each(function(OrderItem $item) use(&$menuItemSheets, &$itensQuantities, $payloadMenuItemIds, $payloadQuantities) {
            if ($item->menuItem->isEnableTechnicalheet() && $item->menuItem->technicalSheet && in_array($item->menu_item_id, $payloadMenuItemIds)){
                $itemIndex = array_search($item->menu_item_id, $payloadMenuItemIds);
                $menuItemSheets[] = $item->menuItem->technicalSheet;
                $itensQuantities[$item->menu_item_id] = $payloadQuantities[$itemIndex];
            }
        });
        if ($menuItemSheets != []){
            foreach ($menuItemSheets as $menuItemSheet){
                $menuItemSheet->each(function(TechnicalSheet $sheet) use ($payload, $reference, $itensQuantities){
                    $itemQuantity = $itensQuantities[$sheet->menu_item_id] * $sheet->quantity;
                    $product = $sheet->product;
                    $movement = $this->stockMovmentRepository->findLatestByproduct($product);
                    if ($itemQuantity > $movement->current_stock) {
                        throw new StockMovementException("{$product->name} está com estoque indisponivel para concluir esse pedido.", 400);
                    }
                    $payload = [
                        "product_id" => $sheet->product->id,
                        "quantity"  => $itemQuantity,
                        "direction" => StockMovmentDirectionEnum::OUT->value,
                        "reference_type"    => StockMovmentReferenceTypeEnum::SALE->value,
                        "reference_id"      => $reference->id
                    ];
                    $this->stockMovmentRepository->save($payload);
                });
            }
        }
    }
}