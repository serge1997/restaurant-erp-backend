<?php
namespace App\Modules\StockMovment\Exceptions;

use Throwable;

class StockMovementException extends \Exception
{
    public function __construct(string $message = "", int $code = 501, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}