<?php
namespace App\Modules\StockMovment\Handlers;


use App\Foundation\Base\BaseModel;
use App\Models\Product;
use App\Modules\StockMovment\Enums\StockMovmentDirectionEnum;
use App\Modules\StockMovment\Handlers\Contracts\StockMovmentHandlerInterface;
use App\Modules\StockMovment\Repository\StockMovmentRepository;

class ManualOutHandler implements StockMovmentHandlerInterface
{

    public function __construct(
        private readonly StockMovmentRepository $stockMovmentRepository
    ){}
   
    public function handle(?BaseModel $reference, array $payload, ?Product $product = null)
    {
        $stockProduct = $this->stockMovmentRepository->findLatestByproduct($product);
        if (!$stockProduct) {
            throw new \Exception("Produto sem estoque", 400);
        }
        if ($stockProduct->current_stock < $payload["quantity"]) {
            throw new \Exception("Quantidade insuficiente em estoque", 400);
        }
        $payload["quantity"] = abs($payload["quantity"]);
        $payload["direction"] = StockMovmentDirectionEnum::OUT->value;
        $this->stockMovmentRepository->save($payload);
    }
}