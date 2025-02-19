<?php

namespace App\Domain\Concept\User;

use App\Domain\Abstract\AbstractId;
use App\Domain\Concept\Misc\InvalidArgumentException;
use App\Domain\Support\UuidV7Generator;

final readonly class UserId extends AbstractId
{
    public function __construct(public string $value)
    {
        if (self::isUuid($this->value) === false) {
            throw new InvalidArgumentException(
                "Invalid User ID format: $value"
            );
        }
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    private static function isUuid(string $value): bool
    {
        $pattern = '/^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$/';

        return preg_match($pattern, $value);
    }

    public static function generate(): self
    {
        return new self(UuidV7Generator::generate());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}