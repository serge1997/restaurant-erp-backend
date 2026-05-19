<?php
namespace App\Modules\StockMovment\Handlers\Contracts;

use App\Foundation\Base\BaseModel;
use App\Models\Product;

interface StockMovmentHandlerInterface
{
    public function handle(?BaseModel $reference, array $payload, ?Product $product = null);
}