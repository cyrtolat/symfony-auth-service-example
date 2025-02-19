<?php

namespace App\Infrastructure\Service;

use App\Application\Contract\JsonWebTokenServiceContract;
use App\Application\Support\Session;
use App\Domain\Concept\User\UserId;
use App\Infrastructure\Support\RedisStorage;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JsonWebTokenService implements JsonWebTokenServiceContract
{
    # access token params
    public readonly string $accessTokenSecretKey;
    public readonly string $accessTokenAlgorithm;
    public readonly int $accessTokenLifetime;

    # refresh token params
    public readonly string $refreshTokenSecretKey;
    public readonly string $refreshTokenAlgorithm;
    public readonly int $refreshTokenLifetime;

    # redis connection instance
    private readonly RedisStorage $redisStorage;

    public function __construct(
        string $accessTokenSecretKey,
        string $accessTokenAlgorithm,
        int $accessTokenLifetime,
        string $refreshTokenSecretKey,
        string $refreshTokenAlgorithm,
        int $refreshTokenLifetime,
        RedisStorage $redisStorage
    )
    {
        $this->accessTokenSecretKey = $accessTokenSecretKey;
        $this->accessTokenAlgorithm = $accessTokenAlgorithm;
        $this->accessTokenLifetime = $accessTokenLifetime;
        $this->refreshTokenSecretKey = $refreshTokenSecretKey;
        $this->refreshTokenAlgorithm = $refreshTokenAlgorithm;
        $this->refreshTokenLifetime = $refreshTokenLifetime;
        $this->redisStorage = $redisStorage;
    }

    public function createAccessToken(Session $session): string
    {
        $payload = [
            'uid' => $session->userId->getValue(),
            'sid' => $session->id,
            'exp' => time() + $this->accessTokenLifetime
        ];

        $redisKey = sprintf("access_token:%s:%s", $session->userId->getValue(), $session->id);

        $this->redisStorage->put($redisKey, $session->id, $payload['exp']);

        return JWT::encode($payload, $this->accessTokenSecretKey, $this->accessTokenAlgorithm);
    }

    public function createRefreshToken(Session $session): string
    {
        $payload = [
            'uid' => $session->userId->getValue(),
            'sid' => $session->id,
            'exp' => time() + $this->refreshTokenLifetime
        ];

        $redisKey = sprintf("refresh_token:%s:%s", $session->userId->getValue(), $session->id);

        $this->redisStorage->put($redisKey, $session->id, $payload['exp']);

        return JWT::encode($payload, $this->refreshTokenSecretKey, $this->refreshTokenAlgorithm);
    }

    public function verifyAccessToken(string $token): ?Session
    {
        $key = new Key($this->accessTokenSecretKey, $this->accessTokenAlgorithm);

        try {
            $decoded = JWT::decode($token, $key);
        } catch (\Exception) {
            return null;
        }

        if (!property_exists($decoded, 'sid') or !property_exists($decoded, 'uid')) {
            return null;
        }

        $redisKey = sprintf("access_token:%s:%s", $decoded->uid, $decoded->sid);

        if (!$this->redisStorage->exists($redisKey)) {
            return null;
        }

        return new Session($decoded->sid, UserId::fromString($decoded->uid));
    }

    public function verifyRefreshToken(string $token): ?Session
    {
        $key = new Key($this->refreshTokenSecretKey, $this->accessTokenAlgorithm);

        try {
            $decoded = JWT::decode($token, $key);
        } catch (\Exception) {
            return null;
        }

        if (!property_exists($decoded, 'sid') or !property_exists($decoded, 'uid')) {
            return null;
        }

        $redisKey = sprintf("refresh_token:%s:%s", $decoded->uid, $decoded->sid);

        if (!$this->redisStorage->exists($redisKey)) {
            return null;
        }

        return new Session($decoded->sid, UserId::fromString($decoded->uid));
    }

    public function revokeAccessToken(Session $session): void
    {
        $redisKey = sprintf("access_token:%s:%s", $session->userId->getValue(), $session->id);

        $this->redisStorage->forget($redisKey);
    }

    public function revokeRefreshToken(Session $session): void
    {
        $redisKey = sprintf("refresh_token:%s:%s", $session->userId->getValue(), $session->id);

        $this->redisStorage->forget($redisKey);
    }
}