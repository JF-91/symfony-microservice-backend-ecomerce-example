<?php
namespace App\Entity;

use App\Enums\ProductsCategory;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    #[Assert\Unique]
    private string $name;

    #[ORM\Column]
    #[Assert\NotBlank]
    private bool $isDeleted;

    #[ORM\Column(type: 'string', length: 255, enumType: ProductsCategory::class)]
    #[Assert\NotBlank]
    #[Assert\Unique]
    private ProductsCategory $productCategory;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private $products;


    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
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

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function setProducts($products): void
    {
        $this->products = $products;
    }


}