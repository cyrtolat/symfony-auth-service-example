<?php

namespace App\Infrastructure\Controller\RefreshToken;

use Symfony\Component\Validator\Constraints as Assert;

readonly class RefreshTokenInputDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $refreshToken,
    ) {}
}