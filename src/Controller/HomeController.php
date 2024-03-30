<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
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
}
