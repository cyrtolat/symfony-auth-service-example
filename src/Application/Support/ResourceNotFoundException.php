<?php

namespace App\Application\Support;

class ResourceNotFoundException extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: "Resource not found.", $code, $previous);
    }

    public static function throwIf(bool $condition, $message = "", int $code = 0, ?\Throwable $previous = null): void
    {
        if ($condition) throw new self($message, $code, $previous);
    }
}