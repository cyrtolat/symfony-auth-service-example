<?php

namespace App\Infrastructure\Support;

use App\Application\Abstract\AbstractCommand;
use App\Application\Abstract\AbstractCommandResult;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function execute(AbstractCommand $command): AbstractCommandResult
    {
        return $this->handle($command);
    }
}