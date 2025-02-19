<?php

namespace App\Infrastructure\Controller\Authenticate;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AuthenticateInputDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $hash,
        #[Assert\NotBlank]
        public array $data,
    ) {}
}