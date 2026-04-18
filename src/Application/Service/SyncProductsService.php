<?php

namespace App\Application\Service;

use App\Core\Contract\IntegrationInterface;
use App\Core\Service\ProductNormalizer;
use App\Core\Service\ProductValidator;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;

class SyncProductsService
{
    public function __construct(
          private ProductNormalizer $normalizer,
          private ProductValidator $validator,
          private ProductRepositoryInterface $repository) 
    {}

    public function sync(IntegrationInterface $integration): void
    {
        foreach ($integration->fetch() as $rawData) {
            $dto = $integration->transform($rawData);
            $this->validator->validate($dto);
            $product = $this->normalizer->normalize($dto);
            $this->repository->save($product);
        }
    }
}