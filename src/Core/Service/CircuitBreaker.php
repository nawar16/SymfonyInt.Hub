<?php

namespace App\Core\Service;

class CircuitBreaker
{
    private array $failures = [];
    private array $lastFailureTime = [];
    private int $threshold = 3;
    private int $cooldown = 30; 

    public function isAvailable(string $key): bool
    {
        if (!isset($this->failures[$key])) 
        {
            return true;
        }
        if ($this->failures[$key] < $this->threshold) 
        {
            return true;
        }
        if (time() - $this->lastFailureTime[$key] > $this->cooldown) 
        {
            $this->reset($key);
            return true;
        }
        return false;
    }
    public function recordFailure(string $key): void
    {
        $this->failures[$key] = ($this->failures[$key] ?? 0) + 1;
        $this->lastFailureTime[$key] = time();
    }
    public function recordSuccess(string $key): void
    {
        $this->reset($key);
    }
    private function reset(string $key): void
    {
        $this->failures[$key] = 0;
        $this->lastFailureTime[$key] = 0;
    }
}