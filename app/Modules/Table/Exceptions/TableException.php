<?php
namespace App\Modules\Table\Exceptions;

use Throwable;

class TableException extends \Exception
{
    public function __construct(string $message, int $code = 400, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}