<?php

namespace App\Infrastructure\Controller\ValidateToken;

use App\Application\UseCase\ValidateToken\ValidateTokenCommand;
use App\Infrastructure\Abstract\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/validate-token', methods: ['POST'])]
class ValidateTokenController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $command = new ValidateTokenCommand($this->parseAuthHeader($request));

        return $this->toJsonResponse($this->executeCommand($command));
    }
}