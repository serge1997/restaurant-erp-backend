<?php
namespace App\Modules\MenuCategory\Exceptions;

use Throwable;

class MenuCategoryException extends \Exception
{
    public function __construct(string $message, int $code = 400, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}