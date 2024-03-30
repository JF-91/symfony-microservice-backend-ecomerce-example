<?php

namespace App\Controller;

use App\Controller\Dto\ProductDto;
use App\Entity\Product;
use App\Enums\ProductsCategory;
use App\Repository\ProductRepository;
use App\Services\ProductDtoMapper;
use App\Services\SerializationService;
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

    private $productDtoMapper;

    private $serializationService;

    public function __construct(
        EntityManagerInterface $manager, 
        ProductRepository $repository, 
        SerializerInterface $serializer,
        ProductDtoMapper $productDtoMapper,
        SerializationService $serializationService)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->productDtoMapper = $productDtoMapper;
        $this->serializationService = $serializationService;
    }


    #[Route('/product', name: 'app_product', methods: ['GET'])]
    public function index(): JsonResponse
    {
       try {
        $products = $this->repository->findAll();
        $productsDTOs = array_map(function($product){
            return $this->productDtoMapper->convertToDtoFromProduct($product);
        }, $products);

        $data = $this->serializationService->serialize($productsDTOs);

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
            $productDto = new ProductDto();

            $productDto->productCategory = ProductsCategory::from($data['productCategory']);
            $productDto->price = $data['price'];
            $productDto->name = $data['name'];
            $productDto->description = $data['description'];
            $productDto->mount = $data['mount'];
            $productDto->isAvailable = $data['isAvailable'];
            $productDto->isDeleted = $data['isDeleted'];

            $product = $this->productDtoMapper->convertToProductFromDto($productDto);
    
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
            $productDto = $this->repository->find($id);
            $productDto = [
                'productCategory' => $productDto->getProductCategory()->value,
                'id' => $productDto->getId(),
                'name' => $productDto->getName(),
                'price' => $productDto->getPrice(),
                'description' => $productDto->getDescription(),
                'mount' => $productDto->getMount(),
                'isAvailable' => $productDto->isIsAvailable(),
                'isDeleted' => $productDto->isIsDeleted()
            ];

            $data = $this->serializer->serialize($productDto, 'json');

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
            $data =  json_decode($request->getContent(), true);

            $productDto = new ProductDto();
            $productDto->productCategory = ProductsCategory::from($data['productCategory']);
            $productDto->price = $data['price'];
            $productDto->name = $data['name'];
            $productDto->description = $data['description'];
            $productDto->mount = $data['mount'];
            $productDto->isAvailable = $data['isAvailable'];
            $productDto->isDeleted = $data['isDeleted'];

            $product = $this->productDtoMapper->convertToProductFromDto($productDto);

            
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

            if(!$product){
                return new JsonResponse('Product not found', Response::HTTP_NOT_FOUND);
            }

            $product->setIsDeleted(true);

            $this->manager->persist($product);
            $this->manager->flush();

            return new JsonResponse('Product deleted successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
