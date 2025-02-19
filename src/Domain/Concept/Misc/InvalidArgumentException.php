<?php

namespace App\Domain\Concept\Misc;

class InvalidArgumentException extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: "Invalid data provided.", $code, $previous);
    }
}