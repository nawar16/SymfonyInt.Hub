<?php

namespace App\Core\Service;

use App\Core\DTO\ProductDTO;
use InvalidArgumentException;

class ProductValidator
{
    public function validate(ProductDTO $dto): void
    {
        empty($dto->name) ? throw new InvalidArgumentException("Name is required"):'';
        $dto->price < 0 ? throw new InvalidArgumentException("Price can't be under zero"):'';
        $dto->stock < 0 ? throw new InvalidArgumentException("Stock can't be under zero"):'';
    }
}