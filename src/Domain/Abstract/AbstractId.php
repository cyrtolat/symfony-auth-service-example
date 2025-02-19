<?php

namespace App\Domain\Abstract;

abstract readonly class AbstractId extends AbstractValue
{
    abstract public function getValue(): string;

    public function __toString(): string
    {
        return $this->getValue();
    }
}