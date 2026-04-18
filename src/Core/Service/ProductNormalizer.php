<?php

namespace App\Core\Service;

use App\Core\DTO\ProductDTO;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;

class ProductNormalizer
{
    public function __construct(private ProductRepositoryInterface $repository) 
    {}

    public function normalize(ProductDTO $dto): Product
    {
        $product = $this->repository->findByExternalId($dto->externalId);
        if (!$product) 
        {
            $product = new Product();
            $product->setExternalId($dto->externalId);
        }
        $product->setName($dto->name);
        $product->setPrice($dto->price);
        $product->setStock($dto->stock);
        $product->setSource($dto->source);
        return $product;
    }
}