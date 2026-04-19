<?php

namespace App\Tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Service\ProductValidator;
use App\Core\DTO\ProductDTO;

class ProductValidatorTest extends TestCase
{
    public function test_it_throws_exception_for_invalid_price(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $validator = new ProductValidator();
        $dto = new ProductDTO(
            externalId: '1',
            name: 'Test',
            price: -10,
            stock: 5,
            source: 'test'
        );
        $validator->validate($dto);
    }
}