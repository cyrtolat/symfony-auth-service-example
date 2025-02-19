<?php

namespace App\Application\Contract;

use App\Domain\Concept\User\UserChatId;

interface TelegramAuthServiceContract
{
    public function verify(string $hash, array $data): ?UserChatId;
}