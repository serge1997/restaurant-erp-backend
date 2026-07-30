<?php
namespace App\Modules\PreRegistration\Exception;

use Throwable;

class PreRegistrationException extends \Exception
{
    public function __construct(string $message, int $code = 501, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }

    public static function existsByCnpj(): self
    {
        return new self("Já existe um registro com esse CNPJ", 409);
    }

    public static function existsByEmail(): self
    {
        return new self("Já existe um registro com esse e-mail", 409);
    }

    public static function tokenExpired(): self
    {
        return new self("Seu token de confirmaçao venceu", 403);
    }
}