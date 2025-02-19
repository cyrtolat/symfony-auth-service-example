<?php

namespace App\Application\UseCase\Authenticate;

use App\Application\Abstract\AbstractCommand;

readonly class AuthenticateCommand extends AbstractCommand
{
    public string $hash;
    public array $data;

    public function __construct(string $hash, array $data)
    {
        $this->hash = $hash;
        $this->data = $data;
    }
}