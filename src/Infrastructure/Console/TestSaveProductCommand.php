<?php

namespace App\Infrastructure\Console;

use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test-save-product')]
class TestSaveProductCommand extends Command
{
    public function __construct(private ProductRepositoryInterface $repository) 
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $product = new Product();
        $product->setExternalId('bla-id-1');
        $product->setName('Test Product');
        $product->setPrice(89.99);
        $product->setStock(10);
        $product->setSource('manual');
        $this->repository->save($product);
        $output->writeln('Done, product saved!');
        $this->repository->remove($product);
        $output->writeln('Done, product deleted!');
        return Command::SUCCESS;
    }
}