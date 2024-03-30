<?php
namespace App\Services;

use App\Controller\Dto\ProductDto;
use App\Enums\ProductsCategory;
use App\Entity\Product;

class ProductDtoMapper {
    // public static function convertToDto(ProductDto $dto): Product
    // {
    //     $product = new Product();
    //     $product->setProductCategory($dto->productCategory);
    //     $product->setName($dto->name);
    //     $product->setPrice($dto->price);
    //     $product->setDescription($dto->description);
    //     $product->setMount($dto->mount);
    //     $product->setIsAvailable($dto->isAvailable);
    //     $product->setIsDeleted($dto->isDeleted);
    //     return $product;
    // }

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
}
