<?php
namespace App\Modules\StockMovment\Handlers;

use App\Models\Product;
use App\Foundation\Base\BaseModel;
use App\Models\OrderItem;
use App\Models\StockMovment;
use App\Models\TechnicalSheet;
use App\Modules\Alert\Enums\AlertSeverityEnum;
use App\Modules\Alert\Infra\Repository\AlertRepository;
use App\Modules\StockMovment\Enums\StockMovmentDirectionEnum;
use App\Modules\StockMovment\Exceptions\StockMovementException;
use App\Modules\StockMovment\Handlers\Contracts\StockMovmentHandlerInterface;
use App\Modules\StockMovment\Repository\StockMovmentRepository;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;

class SaleHandler implements StockMovmentHandlerInterface
{
    public function __construct(
        private readonly StockMovmentRepository $stockMovmentRepository,
        private readonly AlertRepository $alertRepository
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
                if(!in_array($item->menu_item_id, array_keys($itensQuantities))){
                    $itemIndex = array_search($item->menu_item_id, $payloadMenuItemIds);
                    $menuItemSheets[] = $item->menuItem->technicalSheet;
                    $itensQuantities[$item->menu_item_id] = $payloadQuantities[$itemIndex];
                }
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
                    /** @var StockMovment $stock */
                    $stock = $this->stockMovmentRepository->save($payload);

                    if($product->isStockAlertable($stock->current_stock)){
                        /** @var Product $product */
                        $product = $stock->product;
                        $alertPayload = [
                            "title"         => sprintf("%s está com estoque insponivel", $product->name),
                            "description"   => "A quantidade desse produto está zerado, todo pedido do item com ficha tecnica habiltado nao podem ser concluido",
                            "severity"      => AlertSeverityEnum::URGENT->value,
                            "is_resolved"   => false,
                            "alertable_type"    => Product::class,
                            "alertable_id"      => $product->id,
                        ];
                        if($product->inStock($stock->current_stock)->isLow()){
                            $alertPayload['title'] = sprintf("%s está com estoque baixo", $product->name);
                            $alertPayload['description']    = "A quantidade desse produto está em baixo da quantidade minima.";
                            $alertPayload["severity"]      = AlertSeverityEnum::WARNING->value;
                        }
                        $this->alertRepository->updateOrCreate($alertPayload);
                    }
                });
            }
        }
    }
}