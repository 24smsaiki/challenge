<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\OrderDetailsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(mercure: true,normalizationContext: ['groups' => ['get']])]
#[Get(security : "is_granted(ROLE_ADMIN) || is_granted('ROLE_SELLER')")]
#[GetCollection(security : "is_granted('ROLE_ADMIN') || is_granted('ROLE_SELLER')")]
#[Put(security : "ROLE_ADMIN")]
#[Delete(security : "ROLE_ADMIN")]
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

    #[Groups(['get'])]
    #[ORM\Column]
    private ?int $state = null;

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

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }
}
