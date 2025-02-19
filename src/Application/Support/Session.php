<?php

namespace App\Application\Support;

use App\Domain\Concept\User\UserId;

readonly class Session
{
    public string $id;
    public UserId $userId;

    public function __construct(string $id, UserId $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public static function start(UserId $userId): self
    {
        return new self(uniqid(), $userId);
    }
}