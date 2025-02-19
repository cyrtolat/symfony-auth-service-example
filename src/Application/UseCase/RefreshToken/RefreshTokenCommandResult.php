<?php

namespace App\Application\UseCase\RefreshToken;

use App\Application\Abstract\AbstractCommandResult;

readonly class RefreshTokenCommandResult extends AbstractCommandResult
{
    public string $accessToken;
    public string $refreshToken;

    public function __construct(string $accessToken, string $refreshToken)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }
}