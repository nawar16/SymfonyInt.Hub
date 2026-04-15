<?php

namespace App\Infrastructure\Console;

use App\Application\Service\SyncProductsService;
use App\Integration\Mock\MockIntegration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test-sync')]
class TestSyncCommand extends Command
{
    public function __construct(private SyncProductsService $syncService) 
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $integration = new MockIntegration();
        $this->syncService->sync($integration);
        $output->writeln('Done from sync');
        return Command::SUCCESS;
    }
}