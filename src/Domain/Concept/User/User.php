<?php

namespace App\Domain\Concept\User;

use App\Domain\Abstract\AbstractEntity;

final class User extends AbstractEntity
{
    private readonly UserId $userId;
    private readonly UserStatus $status;
    private readonly UserChatId $chatId;

    public function __construct(
        UserId $userId,
        UserStatus $status,
        UserChatId $chatId,
    )
    {
        $this->userId = $userId;
        $this->status = $status;
        $this->chatId = $chatId;
    }

    public function getId(): UserId
    {
        return $this->userId;
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function getChatId(): UserChatId
    {
        return $this->chatId;
    }

    public function hasAccess(): bool
    {
        return $this->status == UserStatus::ACTIVE;
    }
}