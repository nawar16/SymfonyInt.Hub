<?php

namespace App\Tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Service\ProductNormalizer;
use App\Core\DTO\ProductDTO;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;

class ProductNormalizerTest extends TestCase
{
    public function test_it_creates_new_product_when_not_exists(): void
    {
        $repo = $this->createMock(ProductRepositoryInterface::class);
        $repo->method('findByExternalId')->willReturn(null);
        $normalizer = new ProductNormalizer($repo);
        $dto = new ProductDTO(
            externalId: '123',
            name: 'Test Product',
            price: 10.5,
            stock: 5,
            source: 'test'
        );
        $product = $normalizer->normalize($dto);
        $this->assertInstanceOf(Product::class, $product);
    }
}