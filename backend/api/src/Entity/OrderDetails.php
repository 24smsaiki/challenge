<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderDetailsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(mercure: true, normalizationContext: ['groups' => ['get']])]
#[ORM\Entity(repositoryClass: OrderDetailsRepository::class)]

class OrderDetails
{
    #[Groups(['get'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['get'])]
    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    private ?Order $myOrder = null;

    #[Groups(['get'])]
    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    private ?Product $item = null;

    #[Groups(['get'])]
    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[Groups(['get'])]
    #[ORM\Column(nullable: true)]
    private ?float $totalPrice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMyOrder(): ?Order
    {
        return $this->myOrder;
    }

    public function setMyOrder(?Order $myOrder): self
    {
        $this->myOrder = $myOrder;

        return $this;
    }

    public function getItem(): ?Product
    {
        return $this->item;
    }

    public function setItem(?Product $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }
}
