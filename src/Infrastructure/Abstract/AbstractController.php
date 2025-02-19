<?php

namespace App\Infrastructure\Abstract;

use App\Application\Abstract\AbstractCommand;
use App\Application\Abstract\AbstractCommandResult;
use App\Infrastructure\Support\JsonResponder;
use App\Infrastructure\Support\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractController extends SymfonyAbstractController
{
    private const string AUTHORIZATION_HEADER = 'Authorization';

    private readonly CommandBus $commandBus;
    private readonly JsonResponder $responder;

    public function __construct(CommandBus $commandBus, JsonResponder $responder)
    {
        $this->commandBus = $commandBus;
        $this->responder = $responder;
    }

    protected function executeCommand(AbstractCommand $command): AbstractCommandResult
    {
        return $this->commandBus->execute($command);
    }

    protected function toJsonResponse(AbstractCommandResult $result, int $code = Response::HTTP_OK): Response
    {
        return $this->responder->toResponse($result, $code);
    }

    protected function parseAuthHeader(Request $request): string
    {
        return $request->headers->get(self::AUTHORIZATION_HEADER, '');
    }
}