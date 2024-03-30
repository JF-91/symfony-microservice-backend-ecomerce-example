<?php

namespace App\Controller;

use App\Entity\Product;
use App\Enums\ProductsCategory;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app_product')]

class ProductController extends AbstractController
{
    private $manager;
    private $repository;
    
    private $serializer;

    public function __construct(EntityManagerInterface $manager, ProductRepository $repository, SerializerInterface $serializer)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    
    #[Route('/product', name: 'app_product', methods: ['GET'])]
    public function index(): JsonResponse
    {
       try {
        $products = $this->repository->findAll();
        $products = array_map(function($product){
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
                'mount' => $product->getMount(),
                'productCategory' => $product->getProductCategory()->value
            ];
        }, $products);
        $data = $this->serializer->serialize($products, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
       } catch (\Throwable $th) {
              return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
       }
        
    }

    #[Route('/product', name: 'app_product_create', methods: ['POST'])]
    public function createProduct( Request $request ): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $product = new Product();

            $productCategory = ProductsCategory::from($data['productCategory']);
            $product->setProductCategory($productCategory);
            // $product->setProductCategory(ProductsCategory::FOOD);
            $product->setPrice($data['price']);
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setMount($data['mount']);
            $this->manager->persist($product);
            $this->manager->flush();
            return new JsonResponse('Product created successfully', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
        
        }
    }

    #[Route('/product/{id}', name: 'app_product_show', methods: ['GET'])]
    public function showProduct(int $id): JsonResponse
    {
        try {
            $product = $this->repository->find($id);
            $product = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
                'mount' => $product->getMount(),
                'productCategory' => $product->getProductCategory()->value
            ];
            $data = $this->serializer->serialize($product, 'json');
            return new JsonResponse($data, Response::HTTP_OK, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        

    }

    #[Route('/product/{id}', name: 'app_product_update', methods: ['PUT'])]
    public function updateProduct(int $id, Request $request): JsonResponse
    {
        try {
            $product = $this->repository->find($id);
            $data = json_decode($request->getContent(), true);
            $product->setPrice($data['price']);
            $product->setName($data['name']);
            $product->setProductCategory($data['productCategory']);
            $product->setDescription($data['description']);
            $product->setMount($data['mount']);
            $this->manager->persist($product);
            $this->manager->flush();
            return new JsonResponse('Product updated successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/product/{id}', name: 'app_product_delete', methods: ['DELETE'])]
    public function deleteProduct(int $id): JsonResponse
    {
        try {
            $product = $this->repository->find($id);
            $this->manager->remove($product);
            $this->manager->flush();
            return new JsonResponse('Product deleted successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
