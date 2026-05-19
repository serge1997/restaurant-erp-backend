<?php
namespace App\Modules\PurchaseRequisition\Exceptions;

use Throwable;

class PurchaseRequisitionException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}