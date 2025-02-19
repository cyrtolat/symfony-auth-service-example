<?php

namespace App\Infrastructure\Mapping;

use App\Domain\Concept\User\User;
use App\Domain\Concept\User\UserChatId;
use App\Domain\Concept\User\UserId;
use App\Domain\Concept\User\UserStatus;

readonly class UserMapper
{
    private User $instance;

    public function __construct(UserDTO $dto)
    {
        $this->instance = new User(
            userId: new UserId($dto->id),
            status: UserStatus::from($dto->status),
            chatId: new UserChatId($dto->chatId),
        );
    }

    public function getResult(): User
    {
        return $this->instance;
    }
}