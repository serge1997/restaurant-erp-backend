<?php
namespace App\Modules\StockMovment\Handlers;

use App\Foundation\Base\BaseModel;
use App\Models\MenuItem;
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
    }
}