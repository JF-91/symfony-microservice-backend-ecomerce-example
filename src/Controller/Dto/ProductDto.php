<?php 
namespace App\Controller\Dto;

use App\Entity\Category;
use App\Entity\Product;
use App\Enums\ProductsCategory;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDto {


    public ?int $id;

    #[Assert\NotBlank]
    public ProductsCategory $productCategory;

    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public float $price;

    #[Assert\NotBlank]
    public string $description;

    #[Assert\NotBlank]
    public int $mount;

    #[Assert\NotBlank]
    public bool $isAvailable;

    #[Assert\NotBlank]
    public bool $isDeleted;

    public Category $category;

    public static function fromEntity(Product $product): self
    {
        $dto = new self();
        $dto->id = $product->getId();
        $dto->productCategory = $product->getProductCategory();
        $dto->name = $product->getName();
        $dto->price = $product->getPrice();
        $dto->description = $product->getDescription();
        $dto->mount = $product->getMount();
        $dto->isAvailable = $product->isIsAvailable();
        $dto->isDeleted = $product->isIsDeleted();
        $dto->category = $product->getCategory();
        return $dto;
    }
}