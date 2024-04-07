<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Services\ProductDtoMapper;
use App\Services\SerializationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app_category')]

class CategoryController extends AbstractController
{
    private $manager;
    private $repository;

    private $serializer;

    private $categoryMapper;

    public function __construct(
        EntityManagerInterface $manager, 
        CategoryRepository $repository, 
        SerializationService $serializer,
        ProductDtoMapper $categoryMapper)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->categoryMapper = $categoryMapper;
    }
    

    #[Route('/category', name: 'app_category', methods: ['GET'])]
    public function index(): JsonResponse
    {
        try {
            $categories = $this->repository->findAll();
            $categoriesDto = array_map(function($category){
                return $this->categoryMapper->convertToDtoFromCategory($category);
            }, $categories);

            $data = $this->serializer->serialize($categoriesDto);
            return new JsonResponse($data, Response::HTTP_OK, [], true);


        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/category/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->repository->find($id);
            if(!$category){
                return new JsonResponse("Category not found", Response::HTTP_NOT_FOUND);
            }
            $categoryDto = $this->categoryMapper->convertToDtoFromCategory($category);
            $data = $this->serializer->serialize($categoryDto);
            return new JsonResponse($data, Response::HTTP_OK, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/category', name: 'app_category_create', methods: ['POST'])]
    public function createCategory( Request $request ): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $category = $this->categoryMapper->convertToCategoryFromDto($data);
            $this->manager->persist($category);
            $this->manager->flush();
            $categoryDto = $this->categoryMapper->convertToDtoFromCategory($category);
            $data = $this->serializer->serialize($categoryDto);
            return new JsonResponse($data, Response::HTTP_CREATED, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/category/{id}', name: 'app_category_update', methods: ['PUT'])]
    public function updateCategory(int $id, Request $request): JsonResponse
    {
        try {
            $category = $this->repository->find($id);
            if(!$category){
                return new JsonResponse("Category not found", Response::HTTP_NOT_FOUND);
            }
            $data = json_decode($request->getContent(), true);
            $category = $this->categoryMapper->convertToCategoryFromDto($data);
            $this->manager->flush();
            $categoryDto = $this->categoryMapper->convertToDtoFromCategory($category);
            $data = $this->serializer->serialize($categoryDto);
            return new JsonResponse($data, Response::HTTP_OK, [], true);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
    }


    #[Route('/category/{id}', name: 'app_category_delete', methods: ['DELETE'])]
    public function deleteCategory(int $id): JsonResponse
    {
        try {
            $category = $this->repository->find($id);
            if(!$category){
                return new JsonResponse("Category not found", Response::HTTP_NOT_FOUND);
            }
            $this->manager->remove($category);
            $this->manager->flush();
            return new JsonResponse("Category deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}