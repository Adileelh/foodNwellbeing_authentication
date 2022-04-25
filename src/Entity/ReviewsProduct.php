<?php

namespace App\Entity;

use App\Repository\ReviewsProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsProductRepository::class)]
class ReviewsProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $starScore;

    #[ORM\Column(type: 'text', nullable: true)]
    private $comment;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reviewsProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'reviewsProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStarScore(): ?int
    {
        return $this->starScore;
    }

    public function setStarScore(int $starScore): self
    {
        $this->starScore = $starScore;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
