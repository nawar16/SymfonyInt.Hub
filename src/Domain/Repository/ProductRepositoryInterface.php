<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function findPaginated(int $page, int $limit): array;
    public function findAll(): array;
    public function save(Product $product): void;
    public function findByExternalId(string $externalId): ?Product;
    public function remove(Product $product): void;
}