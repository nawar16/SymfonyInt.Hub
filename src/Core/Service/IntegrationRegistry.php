<?php

namespace App\Core\Service;

use App\Core\Contract\IntegrationInterface;

class IntegrationRegistry
{
    public function __construct(private iterable $integrations) 
    {}

    public function get(string $name): IntegrationInterface
    {
        foreach ($this->integrations as $integration) {
            if ($integration->supports($name)) {
                return $integration;
            }
        }
        throw new \RuntimeException('Integration '+$name+' not found');
    }
}