<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'text', nullable: true)]
    private $moreInformation;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isBestSeller = false;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isNewArrival = false;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isFeatured = false;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isSpecialOffer = false;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $brand;

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'products')]
    private $category;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: RelatedProduct::class)]
    private $relatedProducts;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ReviewsProduct::class)]
    private $reviewsProducts;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'text', nullable: true)]
    private $tags;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->tagProducts = new ArrayCollection();
        $this->relatedProducts = new ArrayCollection();
        $this->reviewsProducts = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMoreInformation(): ?string
    {
        return $this->moreInformation;
    }

    public function setMoreInformation(?string $moreInformation): self
    {
        $this->moreInformation = $moreInformation;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsBestSeller(): ?bool
    {
        return $this->isBestSeller;
    }

    public function setIsBestSeller(?bool $isBestSeller): self
    {
        $this->isBestSeller = $isBestSeller;

        return $this;
    }

    public function getIsNewArrival(): ?bool
    {
        return $this->isNewArrival;
    }

    public function setIsNewArrival(?bool $isNewArrival): self
    {
        $this->isNewArrival = $isNewArrival;

        return $this;
    }

    public function getIsFeatured(): ?bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(?bool $isFeatured): self
    {
        $this->isFeatured = $isFeatured;

        return $this;
    }

    public function getIsSpecialOffer(): ?bool
    {
        return $this->isSpecialOffer;
    }

    public function setIsSpecialOffer(?bool $isSpecialOffer): self
    {
        $this->isSpecialOffer = $isSpecialOffer;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

   

    /**
     * @return Collection<int, RelatedProduct>
     */
    public function getRelatedProducts(): Collection
    {
        return $this->relatedProducts;
    }

    public function addRelatedProduct(RelatedProduct $relatedProduct): self
    {
        if (!$this->relatedProducts->contains($relatedProduct)) {
            $this->relatedProducts[] = $relatedProduct;
            $relatedProduct->setProduct($this);
        }

        return $this;
    }

    public function removeRelatedProduct(RelatedProduct $relatedProduct): self
    {
        if ($this->relatedProducts->removeElement($relatedProduct)) {
            // set the owning side to null (unless already changed)
            if ($relatedProduct->getProduct() === $this) {
                $relatedProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReviewsProduct>
     */
    public function getReviewsProducts(): Collection
    {
        return $this->reviewsProducts;
    }

    public function addReviewsProduct(ReviewsProduct $reviewsProduct): self
    {
        if (!$this->reviewsProducts->contains($reviewsProduct)) {
            $this->reviewsProducts[] = $reviewsProduct;
            $reviewsProduct->setProduct($this);
        }

        return $this;
    }

    public function removeReviewsProduct(ReviewsProduct $reviewsProduct): self
    {
        if ($this->reviewsProducts->removeElement($reviewsProduct)) {
            // set the owning side to null (unless already changed)
            if ($reviewsProduct->getProduct() === $this) {
                $reviewsProduct->setProduct(null);
            }
        }

        return $this;
    }
     public function __toString()
    {
        return $this->name;
        return $this->quantity;
    }

     public function getQuantity(): ?int
     {
         return $this->quantity;
     }

     public function setQuantity(int $quantity): self
     {
         $this->quantity = $quantity;

         return $this;
     }

     public function getCreatedAt(): ?\DateTimeImmutable
     {
         return $this->createdAt;
     }

     public function setCreatedAt(\DateTimeImmutable $createdAt): self
     {
         $this->createdAt = $createdAt;

         return $this;
     }

     public function getTags(): ?string
     {
         return $this->tags;
     }

     public function setTags(?string $tags): self
     {
         $this->tags = $tags;

         return $this;
     }

     public function getSlug(): ?string
     {
         return $this->slug;
     }

     public function setSlug(string $slug): self
     {
         $this->slug = $slug;

         return $this;
     }
}
