<?php

namespace App\Infrastructure\Mapping;

use App\Infrastructure\Database\UserOrmModel;

readonly class UserDTO
{
    public string $id;
    public int $status;
    public string $chatId;

    public function __construct(string $id, int $status, string $chatId)
    {
        $this->id = $id;
        $this->status = $status;
        $this->chatId = $chatId;
    }

    public static function fromOrmModel(UserOrmModel $userOrmModel): self
    {
        return new self(
            id: $userOrmModel->id,
            status: $userOrmModel->status,
            chatId: $userOrmModel->chatId,
        );
    }
}