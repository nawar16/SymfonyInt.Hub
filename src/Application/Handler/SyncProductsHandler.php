<?php

namespace App\Application\Handler;

use App\Application\Message\SyncProductsMessage;
use App\Application\Service\SyncProductsService;
use App\Core\Service\IntegrationRegistry;
use App\Integration\Mock\MockIntegration;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SyncProductsHandler
{
    public function __construct(private SyncProductsService $syncService, private IntegrationRegistry $registry) 
    {}

    public function __invoke(SyncProductsMessage $message): void
    {
        //$integration = new MockIntegration();

        $integration = $this->registry->get($message->integrationName);
        $this->syncService->sync($integration);
    }
}