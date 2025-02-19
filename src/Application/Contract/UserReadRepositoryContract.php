<?php

namespace App\Application\Contract;

use App\Domain\Concept\User\User;
use App\Domain\Concept\User\UserChatId;
use App\Domain\Concept\User\UserId;

interface UserReadRepositoryContract
{
    public function getByIdOrNull(UserId $userId): ?User;

    public function getByChatIdOrNull(UserChatId $chatId): ?User;
}