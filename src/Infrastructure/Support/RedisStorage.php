<?php

namespace App\Infrastructure\Support;

use Redis as PhpRedis;

class RedisStorage
{
    protected PhpRedis $phpRedis;
    protected string $keySalt;

    public function __construct(string $host, int $port, ?string $pass = null, $salt = "")
    {
        $pass = $pass == "" ? null : $pass;

        $this->phpRedis = new PhpRedis();

        $this->phpRedis->connect($host, $port, 0, null, 0, 0, ['auth' => [$pass]]);

        $this->keySalt = $salt;
    }

    public function put(string $key, mixed $value, int $expiredAt): bool
    {
        $key = $this->keySalt . ":" . $key;

        return $this->phpRedis->set($key, $value, ['EXAT' => $expiredAt]);
    }

    public function get(string $key): mixed
    {
        $key = $this->keySalt . ":" . $key;

        return $this->phpRedis->get($key);
    }

    public function exists(string $key): bool
    {
        $key = $this->keySalt . ":" . $key;

        return $this->phpRedis->exists($key);
    }

    public function forget(string $key): void
    {
        $key = $this->keySalt . ":" . $key;

        $this->phpRedis->del($key);
    }

    public function forgetByPattern(string $pattern, string ...$excepts): void
    {
        $cursor = null; $pattern = $this->keySalt.":".$pattern;

        while ($result = $this->phpRedis->scan($cursor, $pattern)) {
            foreach ($result as $key) if (! in_array(
                $key, $excepts)) $this->phpRedis->del($key);
        }
    }
}