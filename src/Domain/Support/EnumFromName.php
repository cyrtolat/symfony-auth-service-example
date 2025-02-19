<?php

namespace App\Domain\Support;

trait EnumFromName
{
    public static function fromName(string $name): self
    {
        foreach (static::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        throw new \InvalidArgumentException(sprintf(
            'Invalid enum name "%s" for enum "%s".',
            $name, static::class
        ));
    }

    public static function tryFromNameOrNull(string $name): ?self
    {
        try {
            return static::fromName(strtoupper($name));
        } catch (\Throwable) {
            return null;
        }
    }
}