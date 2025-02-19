<?php

namespace App\Infrastructure\Controller\RefreshToken;

use App\Application\UseCase\RefreshToken\RefreshTokenCommand;
use App\Infrastructure\Abstract\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/refresh-token', methods: ['POST'])]
class RefreshTokenController extends AbstractController
{
    public function __invoke(#[MapRequestPayload] RefreshTokenInputDTO $input): Response
    {
        $command = new RefreshTokenCommand($input->refreshToken);

        return $this->toJsonResponse($this->executeCommand($command));
    }
}