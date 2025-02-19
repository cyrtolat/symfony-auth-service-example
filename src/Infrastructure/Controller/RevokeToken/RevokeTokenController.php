<?php

namespace App\Infrastructure\Controller\RevokeToken;

use App\Application\UseCase\RevokeToken\RevokeTokenCommand;
use App\Infrastructure\Abstract\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/revoke-token', methods: ['POST'])]
class RevokeTokenController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $command = new RevokeTokenCommand($this->parseAuthHeader($request));

        return $this->toJsonResponse($this->executeCommand($command));
    }
}