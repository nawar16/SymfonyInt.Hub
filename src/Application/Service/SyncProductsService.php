<?php

namespace App\Application\Service;

use App\Core\Contract\IntegrationInterface;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;

class SyncProductsService
{
    public function __construct(private ProductRepositoryInterface $repository) 
    {}

    public function sync(IntegrationInterface $integration): void
    {
        foreach ($integration->fetch() as $rawData) {
            $dto = $integration->transform($rawData);
            $existingProduct = $this->repository->findByExternalId($dto->externalId);
            if ($existingProduct) {
                $product = $existingProduct;
            } 
            else {
                $product = new Product();
                $product->setExternalId($dto->externalId);
            }
            $product->setName($dto->name);
            $product->setPrice($dto->price);
            $product->setStock($dto->stock);
            $product->setSource($dto->source);
            $this->repository->save($product);
        }
    }
}