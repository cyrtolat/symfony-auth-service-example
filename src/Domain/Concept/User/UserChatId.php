<?php

namespace App\Domain\Concept\User;

use App\Domain\Abstract\AbstractId;
use App\Domain\Concept\Misc\InvalidArgumentException;

final readonly class UserChatId extends AbstractId
{
    public function __construct(public string $value)
    {
        if (self::isUuid($this->value) === false) {
            throw new InvalidArgumentException(
                "Invalid chat ID format: $value"
            );
        }
    }

    private static function isUuid(string $value): bool
    {
        return preg_match('/^-?\d{5,15}$/', $value);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}