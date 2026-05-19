<?php
namespace App\Modules\Product\Exceptions;

use Throwable;

class ProductException extends \Exception
{
    public function __construct(string $message, int $code = 400, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}