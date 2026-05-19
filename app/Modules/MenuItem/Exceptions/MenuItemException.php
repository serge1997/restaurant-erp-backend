<?php
namespace App\Modules\MenuItem\Exceptions;

use Throwable;

class MenuItemException extends \Exception
{
    public function __construct(string $message = "", int $code = 501, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}