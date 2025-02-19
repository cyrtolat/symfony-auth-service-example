<?php

namespace App\Infrastructure\Database;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'users')]
class UserOrmModel
{
    #[Id, Column(type: 'string')]
    public string $id;

    #[Column(type: 'integer')]
    public int $status;

    #[Column(type: 'string')]
    public string $chatId;
}