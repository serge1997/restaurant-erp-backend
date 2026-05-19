<?php
namespace App\Modules\PurchaseRequisition\Exceptions;

use Exception;
use Throwable;

class PurchaseRequisitionNotFountException extends Exception
{
    public function __construct(string $message = "Requisiçao de compra nao encontrada", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}