<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\OrderDetailsReturnRepository;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(mercure: true, denormalizationContext: ['groups' => 'post'], normalizationContext: ['groups' => 'get'])]
#[GetCollection(security: "is_granted('ROLE_SELLER') || is_granted('ROLE_ADMIN')")]
#[ORM\Entity(repositoryClass: OrderDetailsReturnRepository::class)]
class OrderDetailsReturn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get'])]
    private ?int $id = null;

   
    #[Groups(['get'])]
    #[ORM\ManyToOne(inversedBy: 'orderDetailsReturns')]
    private ?Product $item = null;

    #[Groups(['get'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reason = null;

    #[Groups(['get'])]
    #[ORM\ManyToOne(inversedBy: 'orderDetailsReturns')]
    private ?OrderReturn $myOrderReturn = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getMyOrderReturn(): ?OrderReturn
    {
        return $this->myOrderReturn;
    }

    public function setMyOrderReturn(?OrderReturn $myOrderReturn): self
    {
        $this->myOrderReturn = $myOrderReturn;

        return $this;
    }
}
