<?php
namespace App\Modules\User\Exceptions;

use Throwable;

class UserException extends \Exception
{
    public function __construct(string $message, int $code = 400, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
    public static function userNotFound(): self
    {
        return new self('User not found.');
    }

    public static function emailAlreadyExists(): self
    {
        return new self('Email already exists.');
    }

    public static function invalidCredentials(): self
    {
        return new self('Invalid credentials provided.');
    }
}