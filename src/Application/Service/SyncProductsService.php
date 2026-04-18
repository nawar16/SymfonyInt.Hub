<?php

namespace App\Application\Service;

use App\Core\Contract\IntegrationInterface;
use App\Core\Service\ProductNormalizer;
use App\Core\Service\ProductValidator;
use App\Core\Service\SyncLogger;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Throwable;

class SyncProductsService
{
    public function __construct(
          private ProductNormalizer $normalizer,
          private ProductValidator $validator,
          private ProductRepositoryInterface $repository,
          private SyncLogger $logger) 
    {}

    public function sync(IntegrationInterface $integration): void
    {
        try{
            foreach ($integration->fetch() as $rawData) 
            {
                try {
                    $dto = $integration->transform($rawData);
                    $this->validator->validate($dto);
                    $product = $this->normalizer->normalize($dto);
                    $this->repository->save($product);
                } catch (\Throwable $e) {
                    $this->logger->log('integration', 'failed_item', $e->getMessage());
                }
            }
            $this->logger->log('integration', 'success');
        } catch (Throwable $e) 
        {
            $this->logger->log('integration', 'failed', $e->getMessage());
        }
    }
}