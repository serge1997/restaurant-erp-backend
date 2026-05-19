<?php
namespace App\Modules\MenuItem\Exceptions;

use Throwable;

class MenuItemNotFountException extends \Exception
{
    public function __construct(string $message = "Item do menu nao encontrado", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}