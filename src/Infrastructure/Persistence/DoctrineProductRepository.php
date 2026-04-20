<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductRepository implements ProductRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) 
    {}
        
    public function findPaginated(int $page, int $limit): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit)
            ->getQuery()
            ->getResult();
    }
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(Product::class)
            ->findAll();
    }
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