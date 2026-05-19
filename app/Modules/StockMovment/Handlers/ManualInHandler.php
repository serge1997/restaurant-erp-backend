<?php
namespace App\Modules\StockMovment\Handlers;


use App\Foundation\Base\BaseModel;
use App\Models\Product;
use App\Modules\StockMovment\Enums\StockMovmentDirectionEnum;
use App\Modules\StockMovment\Handlers\Contracts\StockMovmentHandlerInterface;
use App\Modules\StockMovment\Repository\StockMovmentRepository;

class ManualInHandler implements StockMovmentHandlerInterface
{
    public function __construct(
        private readonly StockMovmentRepository $stockMovmentRepository
    ){}

    public function handle(?BaseModel $reference, array $payload, ?Product $product = null)
    {
        $payload["direction"] = StockMovmentDirectionEnum::IN->value;
        $this->stockMovmentRepository->save($payload);
    }
}