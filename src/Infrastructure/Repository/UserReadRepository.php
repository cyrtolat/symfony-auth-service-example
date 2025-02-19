<?php

namespace App\Infrastructure\Repository;

use App\Application\Contract\UserReadRepositoryContract;
use App\Domain\Concept\User\User;
use App\Domain\Concept\User\UserChatId;
use App\Domain\Concept\User\UserId;
use App\Infrastructure\Database\UserOrmModel;
use App\Infrastructure\Mapping\UserDTO;
use App\Infrastructure\Mapping\UserMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserReadRepository extends ServiceEntityRepository implements UserReadRepositoryContract
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOrmModel::class);
    }

    public function getByIdOrNull(UserId $userId): ?User
    {
        $ormModel = $this->findOneBy(['id' => $userId]);

        if ($ormModel === null) return null;

        $dto = UserDTO::fromOrmModel($ormModel);

        return (new UserMapper($dto))->getResult();
    }

    public function getByChatIdOrNull(UserChatId $chatId): ?User
    {
        $ormModel = $this->findOneBy(['chatId' => $chatId]);

        if ($ormModel === null) return null;

        $dto = UserDTO::fromOrmModel($ormModel);

        return (new UserMapper($dto))->getResult();
    }
}