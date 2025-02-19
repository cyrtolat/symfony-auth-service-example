<?php

namespace App\Application\UseCase\RevokeToken;

use App\Application\Abstract\AbstractCommandResult;

readonly class RevokeTokenCommandResult extends AbstractCommandResult
{
    public function __construct(public string $result = 'ok') {}
}