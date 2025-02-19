<?php

namespace App\Application\Contract;

use App\Application\Support\Session;

interface JsonWebTokenServiceContract
{
    public function createAccessToken(Session $session): string;

    public function createRefreshToken(Session $session): string;

    public function verifyAccessToken(string $token): ?Session;

    public function verifyRefreshToken(string $token): ?Session;

    public function revokeAccessToken(Session $session): void;

    public function revokeRefreshToken(Session $session): void;
}