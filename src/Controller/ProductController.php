<?php

namespace App\Controller;

use App\Domain\Entity\SyncLog;
use App\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;

class ProductController extends AbstractController
{
    #[Route('/api/products', methods: ['GET'])]
    #[OA\Get(
        path: "/api/products",
        summary: "Get all products",
        responses: [
            new OA\Response(
                response: 200,
                description: "Returns products"
            )
        ]
    )]
    public function index(ProductRepositoryInterface $repository, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 10; 
        $products = $repository->findPaginated($page, $limit);
        return $this->json($products, 200, [], [
            'groups' => ['product:read']
        ]);
    }

    #[Route('/api/logs', methods: ['GET'])]
    #[OA\Get(
        path: "/api/logs",
        summary: "Get logs",
        responses: [
            new OA\Response(
                response: 200,
                description: "Returns products' logs"
            )
        ]
    )]
    public function logs(EntityManagerInterface $entityManager): JsonResponse
    {
        $logs = $entityManager->getRepository(SyncLog::class)
        ->findBy([], ['createdAt' => 'DESC']);
        // $data = array_map(fn($log) => [
        //     'integration' => $log->getIntegration(),
        //     'status' => $log->getStatus(),
        //     'message' => $log->getMessage(),
        //     'createdAt' => $log->getCreatedAt()->format('Y-m-d H:i:s'),
        // ], $logs);
        // return $this->json($data);
        return $this->json($logs, 200, [], [
            'groups' => ['synclog:read']
        ]);
    }
}


