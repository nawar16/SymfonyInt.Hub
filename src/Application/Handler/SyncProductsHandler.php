<?php

namespace App\Application\Handler;

use App\Application\Message\SyncProductsMessage;
use App\Application\Service\SyncProductsService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SyncProductsHandler
{
    public function __construct(private SyncProductsService $syncService) 
    {}

    public function __invoke(SyncProductsMessage $message): void
    {
    }
}