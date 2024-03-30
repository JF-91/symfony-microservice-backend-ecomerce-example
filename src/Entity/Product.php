<?php

namespace App\Entity;

use App\Enums\ProductsCategory;
use App\Repository\ProductRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{


    public function __construct() {
        $this->createdAt = new DateTimeImmutable(); 
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255, enumType: ProductsCategory::class)]
    private ProductsCategory $productCategory;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $name;


    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?float $price;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $mount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMount(): ?int
    {
        return $this->mount;
    }

    public function setMount(int $mount): static
    {
        $this->mount = $mount;

        return $this;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProductCategory()
    {
        return $this->productCategory;
    }

    public function setProductCategory(ProductsCategory $productCategory): static
    {
        $this->productCategory = $productCategory;

        return $this;
    }

}
