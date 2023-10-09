<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ProductController extends AbstractController
{
    private $manager;
    private $serializer;
    public function __construct(EntityManagerInterface $manager, SerializerInterface $serializer)
    {
        $this->manager = $manager;    
        $this->serializer = $serializer;
    }
    #[Route('/product', name: 'app_product', methods: ['GET'])]
    public function index(): JsonResponse
    {
        try {
            $products = $this->manager->getRepository(Product::class)->findAll();
            $products = $this->serializer->serialize($products, 'json');
            return new JsonResponse($products, Response::HTTP_OK, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_BAD_REQUEST, [], true);
        }

    }


    #[Route('/product/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->manager->getRepository(Product::class)->find($id);
            $product = $this->serializer->serialize($product, 'json');
            return new JsonResponse($product, Response::HTTP_OK, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

    #[Route('/product', name: 'app_product_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $product = $this->serializer->deserialize($request->getContent(), Product::class, 'json');
            $this->manager->persist($product);
            $this->manager->flush();
            $product = $this->serializer->serialize($product, 'json');
            return new JsonResponse($product, Response::HTTP_CREATED, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

    #[Route('/product/{id}', name: 'app_product_update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $product = $this->manager->getRepository(Product::class)->find($id);
            $product = $this->serializer->deserialize($request->getContent(), Product::class, 'json');
            $this->manager->persist($product);
            $this->manager->flush();
            $product = $this->serializer->serialize($product, 'json');
            return new JsonResponse($product, Response::HTTP_OK, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

    #[Route('/product/{id}', name: 'app_product_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $product = $this->manager->getRepository(Product::class)->find($id);
            $this->manager->remove($product);
            $this->manager->flush();
            return new JsonResponse(null, Response::HTTP_NO_CONTENT, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

}
