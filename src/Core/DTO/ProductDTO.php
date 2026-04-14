<?php

namespace App\Core\DTO;

class ProductDTO
{
    public function __construct(
        public readonly string $externalId,
        public readonly string $name,
        public readonly float $price,
        public readonly int $stock,
        public readonly string $source
    ) {}
}