<?php
namespace App\Modules\TechnicalSheet\Exceptions;

use Throwable;

class TecnhicalSheetException extends \Exception
{
    public function __construct(string $message, int $code = 400, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}