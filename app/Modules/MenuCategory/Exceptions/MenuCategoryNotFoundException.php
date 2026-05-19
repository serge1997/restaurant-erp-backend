<?php
namespace App\Modules\MenuCategory\Exceptions;

use Throwable;

class MenuCategoryNotFoundException extends \Exception
{
    public function __construct(string $message = "Categoria do menu nao encontrada", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}