<?php

namespace App\Entity;

use App\Repository\OrderDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailsRepository::class)]
class OrderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $productName;

    #[ORM\Column(type: 'float')]
    private $productPrice;

    #[ORM\Column(type: 'integer')]
    private $productQuantity;

    #[ORM\Column(type: 'float')]
    private $subTotalHT;

    #[ORM\Column(type: 'float')]
    private $tax;

    #[ORM\Column(type: 'float')]
    private $subtotalTTC;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private $orders;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getProductQuantity(): ?int
    {
        return $this->productQuantity;
    }

    public function setProductQuantity(int $productQuantity): self
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    public function getSubTotalHT(): ?float
    {
        return $this->subTotalHT;
    }

    public function setSubTotalHT(float $subTotalHT): self
    {
        $this->subTotalHT = $subTotalHT;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getSubtotalTTC(): ?float
    {
        return $this->subtotalTTC;
    }

    public function setSubtotalTTC(float $subtotalTTC): self
    {
        $this->subtotalTTC = $subtotalTTC;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): self
    {
        $this->orders = $orders;

        return $this;
    }
}
