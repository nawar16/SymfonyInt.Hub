<?php

namespace App\Infrastructure\Http;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class RetryableHttpClient
{
    public function __construct(private HttpClientInterface $client) 
    {}

    public function request(string $method, string $url, array $options = [], int $retries = 3)
    {
        $attempt = 0; $delay = 1;
        while ($attempt < $retries) 
        {
            try {
                return $this->client->request($method, $url, $options);
            } catch (Throwable $e) 
            {
                $attempt++;
                if ($attempt >= $retries) throw $e;
                sleep($delay); // for backoff
                $delay *= 2; 
            }
        }
    }
}