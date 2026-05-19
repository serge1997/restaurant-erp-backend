<?php
namespace App\Modules\Product\Exceptions;

use Exception;
use Throwable;

class ProductNotFountException extends Exception
{
    public function __construct(string $message = "Produto nao encontrado", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}