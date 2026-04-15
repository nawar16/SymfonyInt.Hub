<?php

namespace App\Core\Contract;

use App\Core\DTO\ProductDTO;

interface IntegrationInterface
{
    public function fetch(): iterable;

    public function transform(mixed $data): ProductDTO;
    public function supports(string $name): bool;
}
