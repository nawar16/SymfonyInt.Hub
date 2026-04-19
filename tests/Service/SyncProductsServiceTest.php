<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Application\Service\SyncProductsService;
use App\Integration\Mock\MockIntegration;

class SyncProductsServiceTest extends KernelTestCase
{
    public function test_syncproduct_runs_without_errors(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $service = $container->get(SyncProductsService::class);
        $integration = new MockIntegration();
        $service->sync($integration);
        $this->assertTrue(true);
    }
}