<?php 
namespace App\Controller\Dto;

use App\Entity\Category;
use App\Enums\ProductsCategory;

class CategoryDto {
    public ?int $id;
    public string $name;
    public bool $isDeleted;
    public ProductsCategory $productCategory;

    public static function fromEntity(Category $category): self
    {
        $dto = new self();
        $dto->id = $category->getId();
        $dto->name = $category->getName();
        $dto->isDeleted = $category->isIsDeleted();
        $dto->productCategory = $category->getProductCategory();
        return $dto;
    }
}