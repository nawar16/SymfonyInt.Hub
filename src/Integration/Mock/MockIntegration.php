<?php

namespace App\Integration\Mock;

use App\Core\Contract\IntegrationInterface;
use App\Core\DTO\ProductDTO;

class MockIntegration implements IntegrationInterface
{
    public function fetch(): iterable
    {
        return [
            [
                'id' => '1',
                'name' => 'Product 1',
                'price' => 19.5,
                'stock' => 5,
            ],
            [
                'id' => '2',
                'name' => 'Product 2',
                'price' => 21.0,
                'stock' => 3,
            ],
        ];
    }

    public function transform(mixed $data): ProductDTO
    {
        return new ProductDTO(
            externalId: $data['id'],
            name: $data['name'],
            price: $data['price'],
            stock: $data['stock'],
            source: 'mock'
        );
    }
    public function supports(string $name): bool
    {
        return $name === 'mock';
    }
}