<?php

namespace App\Domain\Abstract;

abstract class AbstractEntity
{
    abstract public function getId(): AbstractId;
}