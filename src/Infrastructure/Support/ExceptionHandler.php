<?php

namespace App\Infrastructure\Support;

use App\Application\Support\AccessDeniedException;
use App\Application\Support\ResourceNotFoundException;
use App\Domain\Concept\Misc\ActionProhibitedException;
use App\Domain\Concept\Misc\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionHandler
{
    public function __construct(private JsonResponder $responder) {}

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        while ($exception) switch (true) {
            case $exception instanceof MethodNotAllowedHttpException:
                $code = Response::HTTP_METHOD_NOT_ALLOWED;
                break 2;

            case $exception instanceof ValidationFailedException:
                $message = 'The provided data is incorrect or incomplete';
                $code = Response::HTTP_UNPROCESSABLE_ENTITY;
                break 2;

            case $exception instanceof AccessDeniedException:
                $code = Response::HTTP_FORBIDDEN;
                break 2;

            case $exception instanceof ResourceNotFoundException:
                $code = Response::HTTP_NOT_FOUND;
                break 2;

            case $exception instanceof ActionProhibitedException:
            case $exception instanceof InvalidArgumentException:
                $code = Response::HTTP_BAD_REQUEST;
                break 2;

            default: if ($previous = $exception->getPrevious()) {
                $exception = $previous;
            } else break 2;
        }

        $payload = ['message' => $message ?? $exception->getMessage()];
        $code = $code ?? Response::HTTP_INTERNAL_SERVER_ERROR;

        $response = $this->responder->toResponse($payload, $code);
        $event->setResponse($response);
    }
}