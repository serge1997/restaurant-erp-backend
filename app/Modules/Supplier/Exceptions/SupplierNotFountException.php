<?php
namespace App\Modules\Supplier\Exceptions;

use Exception;
use Throwable;

class SupplierNotFountException extends Exception
{
    public function __construct(string $message = "Fornecedor nao encontrado", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}