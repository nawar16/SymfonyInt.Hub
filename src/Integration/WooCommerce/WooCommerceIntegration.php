<?php

namespace App\Integration\WooCommerce;

use App\Core\Contract\IntegrationInterface;
use App\Core\DTO\ProductDTO;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WooCommerceIntegration implements IntegrationInterface
{
    public function __construct(private HttpClientInterface $client) 
    {}

    public function supports(string $name): bool
    {
        return $name === 'woocommerce';
    }

    public function fetch(): iterable
    {
        $page = 1;
        do {
            $response = $this->client->request('GET', $_ENV['WC_API_URL'], 
            [
                'query' => ['per_page' => 100, 'page' => $page],
                'auth_basic' => 
                [
                    $_ENV['WC_CONSUMER_KEY'],
                    $_ENV['WC_CONSUMER_SECRET']
                ]
            ]);
            $data = $response->toArray();
            foreach ($data as $item) yield $item;
            $page++;
        } while (!empty($data));
        return $response->toArray();
    }

    public function transform(mixed $data): ProductDTO
    {
        return new ProductDTO(
            externalId: (string) $data['id'],
            name: $data['name'] ?? 'Unnamed',
            price: (float) ($data['price'] ?? 0),
            stock: (int) ($data['stock_quantity'] ?? 0),
            source: 'woocommerce'
        );
    }
}