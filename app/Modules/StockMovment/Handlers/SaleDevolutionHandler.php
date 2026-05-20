<?php
namespace App\Modules\StockMovment\Handlers;

use App\Foundation\Base\BaseModel;
use App\Models\MenuItem;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\TechnicalSheet;
use App\Modules\StockMovment\Enums\StockMovmentDirectionEnum;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
use App\Modules\StockMovment\Exceptions\StockMovementException;
use App\Modules\StockMovment\Handlers\Contracts\StockMovmentHandlerInterface;
use App\Modules\StockMovment\Repository\StockMovmentRepository;

class SaleDevolutionHandler implements StockMovmentHandlerInterface
{

    public function __construct(
        private readonly StockMovmentRepository $stockMovmentRepository
    ){}
    
    //reference here is OrderItem model
    public function handle(?BaseModel $reference, array $payload, ?Product $product = null)
    {
        $payload["direction"] = StockMovmentDirectionEnum::IN->value;
        if(!$payload['is_cancelling_order']){
            /** @var MenuItem $menuItem */
            $menuItem = $reference->menuItem;
            if(!$menuItem) {
                throw new \Exception("Item nao encontrado nesse pedido", 400);
            }
            $menuItemSheet = $menuItem->technicalSheet;
            if (!$menuItemSheet) {
                throw new StockMovementException(
                    "Item sem ficha técnica — não é possível repor o estoque automaticamente.",
                    400
                );
            }
            if ($menuItemSheet != [] || $menuItemSheet != null){
                $menuItemSheet->each(function(TechnicalSheet $sheet) use ($payload, $reference){
                    $itemQuantity = $payload["quantity"];
                    if($itemQuantity > $reference->quantity) {
                        throw new StockMovementException("Quantidade de devolução nao pode ser maior que a quantidade do item no pedido.", 400);
                    }
                    $payload = [
                        "product_id" => $sheet->product->id,
                        "quantity"  => $sheet->quantity * $itemQuantity,
                        "direction" => StockMovmentDirectionEnum::IN->value,
                        "reference_type"    => StockMovmentReferenceTypeEnum::DEVOLUTION_SALE->value,
                        "reference_id"      => $reference->order_id
                    ];
                    $this->stockMovmentRepository->save($payload);
                });
                
            }
        }else{
            $itemRestedQuantities = $payload['reset_stock_quantities'];
            $orderItemsWithTechnicalSheetIds = array_keys($itemRestedQuantities);
            $items = $reference->items()->whereIn('id', $orderItemsWithTechnicalSheetIds)->get();
            $menuItemSheets = [];
            $itensQuantities = [];
            $reference->refresh();
            $items->each(function(OrderItem $item) use(&$menuItemSheets, &$itensQuantities, $itemRestedQuantities) {
                if ($item->menuItem->isEnableTechnicalheet() && $item->menuItem->technicalSheet){
                    $menuItemSheets[] = $item->menuItem->technicalSheet;
                    $itensQuantities[$item->menu_item_id] = $itemRestedQuantities[$item->id];
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
                            "direction" => StockMovmentDirectionEnum::IN->value,
                            "reference_type"    => StockMovmentReferenceTypeEnum::DEVOLUTION_SALE->value,
                            "reference_id"      => $reference->id
                        ];
                        $this->stockMovmentRepository->save($payload);
                    });
                }
            }
        }
    }
}