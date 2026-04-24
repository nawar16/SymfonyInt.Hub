<?php

namespace App\Application\Service;

use App\Core\Contract\IntegrationInterface;
use App\Core\Service\CircuitBreaker;
use App\Core\Service\ProductNormalizer;
use App\Core\Service\ProductValidator;
use App\Core\Service\SyncLogger;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Throwable;

class SyncProductsService
{
    private CircuitBreaker $circuitBreaker;
    public function __construct(
          private ProductNormalizer $normalizer,
          private ProductValidator $validator,
          private ProductRepositoryInterface $repository,
          private SyncLogger $logger) 
    {}

    public function sync(IntegrationInterface $integration): void
    {
        $key = "woocommerce";
        if (!$this->circuitBreaker->isAvailable($key)) 
        {
            $this->logger->log($key, 'skipped', 'Cir breaker is open');
            return;
        }
        try {
            foreach ($integration->fetch() as $rawData) 
            {
                try {
                    $dto = $integration->transform($rawData);
                    $this->validator->validate($dto);
                    $product = $this->normalizer->normalize($dto);
                    $this->repository->save($product);
                } catch (\Throwable $e){
                    $this->logger->log($key, 'failed_item', $e->getMessage());
                }
            }
            $this->circuitBreaker->recordSuccess($key);
            $this->logger->log($key, 'success');
        } catch (\Throwable $e) 
        {
            $this->circuitBreaker->recordFailure($key);
            $this->logger->log($key, 'failed', $e->getMessage());
        }
    }
}