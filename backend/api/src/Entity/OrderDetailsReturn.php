<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderDetailsReturnRepository;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(mercure: true, security: "is_granted('ROLE_SELLER') || is_granted('ROLE_ADMIN')",  denormalizationContext: ['groups' => 'post'], normalizationContext: ['groups' => 'get'])]
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

    // add value for total price of the details return 

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
