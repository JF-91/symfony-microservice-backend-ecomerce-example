<?php
namespace App\Services;

use App\Controller\Dto\ProductDto;
use App\Controller\Dto\CategoryDto;
use App\Entity\Category;
use App\Entity\Product;

class ProductDtoMapper {

    public static function convertToDtoFromProduct(Product $product): ProductDto
{
    $dto = new ProductDto();
    $dto->productCategory = $product->getProductCategory();
    $dto->name = $product->getName();
    $dto->price = $product->getPrice();
    $dto->description = $product->getDescription();
    $dto->mount = $product->getMount();
    $dto->isAvailable = $product->isIsAvailable();
    $dto->isDeleted = $product->isIsDeleted();
    return $dto;
}

    public static function convertToProductFromDto(ProductDto $dto): Product
    {
        $product = new Product();
        $product->setProductCategory($dto->productCategory);
        $product->setName($dto->name);
        $product->setPrice($dto->price);
        $product->setDescription($dto->description);
        $product->setMount($dto->mount);
        $product->setIsAvailable($dto->isAvailable);
        $product->setIsDeleted($dto->isDeleted);
        return $product;
    }

    public static function convertToDtoFromCategory(Category $category): CategoryDto
    {
        $dto = new CategoryDto();
        $dto->id = $category->getId();
        $dto->name = $category->getName();
        $dto->isDeleted = $category->isIsDeleted();
        $dto->productCategory = $category->getProductCategory();
        return $dto;
    }

    public static function convertToCategoryFromDto(CategoryDto $dto): Category
    {
        $category = new Category();
        $category->setName($dto->name);
        $category->setIsDeleted($dto->isDeleted);
        $category->setProductCategory($dto->productCategory);
        return $category;
    }
}
