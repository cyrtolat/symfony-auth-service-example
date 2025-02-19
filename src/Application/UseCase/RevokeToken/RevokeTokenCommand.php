<?php

namespace App\Application\UseCase\RevokeToken;

use App\Application\Abstract\AbstractCommand;

readonly class RevokeTokenCommand extends AbstractCommand
{
    public function __construct(public string $accessToken) {}
}