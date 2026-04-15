<?php

namespace App\Infrastructure\Console;

use App\Application\Message\SyncProductsMessage;
use App\Application\Service\SyncProductsService;
use App\Integration\Mock\MockIntegration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'app:test-sync')]
class TestSyncCommand extends Command
{
    public function __construct(private MessageBusInterface $bus)
        //private SyncProductsService $syncService
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $integration = new MockIntegration();
        // $this->syncService->sync($integration);
        // $output->writeln('Done from sync');
        $this->bus->dispatch(new SyncProductsMessage('mock'));
        $output->writeln('Done from sync with message dispatch');
        return Command::SUCCESS;
    }
}