<?php

namespace App\Controller;

use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    #[Route('/api/products', methods: ['GET'])]
    public function index(ProductRepositoryInterface $repository, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 10; 
        $products = $repository->findPaginated($page, $limit);
        return $this->json($products, 200, [], [
            'groups' => ['product:read']
        ]);
    }
}