<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductRepository implements ProductRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) 
    {}


    public function findByExternalId(string $externalId): ?Product
    {

        return $this->entityManager
            ->getRepository(Product::class)
            ->findOneBy(['externalId' => $externalId]);
    }
    //create & update
    public function save(Product $product): void
    {
        $this->entityManager->persist($product);

        $this->entityManager->flush();
    }
    public function remove(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}