<?php

namespace App\Domain\Concept\User;

use App\Domain\Support\EnumFromName;

enum UserStatus: int
{
    use EnumFromName;

    # Активный
    case ACTIVE = 0;

    # Заблокирован
    case BANNED = 1;
}