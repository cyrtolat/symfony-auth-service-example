<?php

namespace App\Application\UseCase\ValidateToken;

use App\Domain\Concept\User\UserId;
use App\Application\Abstract\AbstractCommandResult;

readonly class ValidateTokenCommandResult extends AbstractCommandResult
{
    public function __construct(public UserId $userId) {}
}