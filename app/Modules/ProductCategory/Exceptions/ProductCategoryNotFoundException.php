<?php
namespace App\Modules\ProductCategory\Exceptions;

use Throwable;

class ProductCategoryNotFoundException extends \Exception
{
    public function __construct(string $message = "Categoria do produto nao encontrada", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}