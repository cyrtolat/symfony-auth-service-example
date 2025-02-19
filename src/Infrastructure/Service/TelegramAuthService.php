<?php

namespace App\Infrastructure\Service;

use App\Application\Contract\TelegramAuthServiceContract;
use App\Domain\Concept\User\UserChatId;

class TelegramAuthService implements TelegramAuthServiceContract
{
    private readonly string $botToken;
    private readonly string $algorithm;
    private readonly string $specialKey;

    public function __construct(string $botToken, string $algorithm, string $specialKey)
    {
        $this->botToken = $botToken;
        $this->algorithm = $algorithm;
        $this->specialKey = $specialKey;
    }

    public function verify(string $hash, array $data): ?UserChatId
    {
        ksort($data); # Сортируем данные по алфавиту. Это необходимо для алгоритма проверки

        $stringForCheck = http_build_query($data, '', "\n");
        $secretKey = hash_hmac($this->algorithm, $this->botToken, $this->specialKey, true);
        $calculatedHash = hash_hmac($this->algorithm, $stringForCheck, $secretKey);

        if (hash_equals($calculatedHash, $hash) === false) return null;

        if (isset($data['user']['id'])) return UserChatId::fromString($data['user']['id']);

        throw new \InvalidArgumentException('Invalid data: missing user chat ID');
    }
}