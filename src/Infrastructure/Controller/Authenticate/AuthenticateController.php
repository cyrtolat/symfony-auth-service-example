<?php

namespace App\Infrastructure\Controller\Authenticate;

use App\Application\UseCase\Authenticate\AuthenticateCommand;
use App\Infrastructure\Abstract\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/authenticate', methods: ['POST'])]
class AuthenticateController extends AbstractController
{
    public function __invoke(#[MapRequestPayload] AuthenticateInputDTO $input): Response
    {
        $command = new AuthenticateCommand($input->hash, $input->data);

        return $this->toJsonResponse($this->executeCommand($command));
    }
}