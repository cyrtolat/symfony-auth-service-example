<?php

namespace App\Domain\Concept\Misc;

class ActionProhibitedException extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?: "The action is prohibited.", $code, $previous);
    }
}