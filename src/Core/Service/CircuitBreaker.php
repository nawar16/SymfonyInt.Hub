<?php

namespace App\Core\Service;

use Psr\Cache\CacheItemPoolInterface;

class CircuitBreaker
{
    private int $threshold = 3;
    private int $cooldown = 30;

    public function __construct(private CacheItemPoolInterface $cache) 
    {}
    public function isAvailable(string $key): bool
    {
        $res = false;
        $failures = $this->getFailures($key);
        if($failures < $this->threshold) return true;
        $lastFailure = $this->getLastFailureTime($key);
        time() - $lastFailure > $this->cooldown ? [$this->reset($key), $res = true]:"";
        return $res;
    }
    public function recordFailure(string $key): void
    {
        $this->cache->getItem("failure_cnt_$key")
            ->set($this->getFailures($key) + 1)
            ->expiresAfter(3600);
        $this->cache->getItem("last_failure_time_$key")
            ->set(time())
            ->expiresAfter(3600);
    }
    public function recordSuccess(string $key): void
    {
        $this->reset($key);
    }
    private function reset(string $key): void
    {
        $this->cache->deleteItem("failure_cnt_$key");
        $this->cache->deleteItem("last_failure_time_$key");
    }
    private function getFailures(string $key): int
    {
        return $this->cache->getItem("failure_cnt_$key")->get() ?? 0;
    }
    private function getLastFailureTime(string $key): int
    {
        return $this->cache->getItem("last_failure_time_$key")->get() ?? 0;
    }
}