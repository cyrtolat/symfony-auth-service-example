<?php

namespace App\Application\UseCase\RefreshToken;

use App\Application\Abstract\AbstractCommand;

readonly class RefreshTokenCommand extends AbstractCommand
{
    public function __construct(public string $refreshToken) {}
}