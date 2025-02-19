<?php

namespace App\Application\UseCase\ValidateToken;

use App\Application\Abstract\AbstractCommand;

readonly class ValidateTokenCommand extends AbstractCommand
{
    public function __construct(public string $accessToken) {}
}