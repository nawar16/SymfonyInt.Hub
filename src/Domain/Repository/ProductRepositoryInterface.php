<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;
    public function findByExternalId(string $externalId): ?Product;
}