<?php

namespace App\Entity;

use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\OrderReturnController;
use App\Repository\OrderReturnRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Controller\ManageReturnByAdminController;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(mercure: true,security: "is_granted('ROLE_USER') || is_granted('ROLE_ADMIN')" ,  denormalizationContext: ['groups' => 'post'], normalizationContext: ['groups' => 'get'])]
#[ORM\Entity(repositoryClass: OrderReturnRepository::class)]
#[Get(security : "is_granted('ROLE_ADMIN')")]
#[GetCollection(security: "is_granted('ROLE_USER') || is_granted('ROLE_ADMIN')")]
#[Delete(security : "ROLE_ADMIN")]
#[Put(security : "ROLE_ADMIN")]
#[ApiResource(operations: [
    new Post(
        uriTemplate: '/order/create/return',
        controller: OrderReturnController::class,
        name: 'order_return',
        security: 'is_granted("ROLE_USER")'
    ),
    new Post(
        uriTemplate: '/ManageReturn',
        controller: ManageReturnByAdminController::class,
        security: "ROLE_ADMIN"
    )
])]
class OrderReturn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get'])]
    private ?int $id = null;
    #[Groups(['get'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;
    
    #[Groups(['get'])]
    #[ORM\Column(nullable: true)]
    private ?int $state = null;

    #[Groups(['get'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[Groups(['get'])]
    #[ORM\OneToMany(mappedBy: 'myOrderReturn', targetEntity: OrderDetailsReturn::class)]
    private Collection $orderDetailsReturns;

    #[Groups(['post','get'])]
    #[ORM\Column(nullable: true)]
    private ?float $totalPrice = null;

    #[Groups(['get'])]
    #[ORM\OneToMany(mappedBy: 'orderreturn', targetEntity: Order::class)]
    private Collection $myOrder;
    
    public function __construct()
    {
        $this->orderDetailsReturns = new ArrayCollection();
        $this->myOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): self
    {
        $this->state = $state;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetailsReturn>
     */
    public function getOrderDetailsReturns(): Collection
    {
        return $this->orderDetailsReturns;
    }

    public function addOrderDetailsReturn(OrderDetailsReturn $orderDetailsReturn): self
    {
        if (!$this->orderDetailsReturns->contains($orderDetailsReturn)) {
            $this->orderDetailsReturns->add($orderDetailsReturn);
            $orderDetailsReturn->setMyOrderReturn($this);
        }

        return $this;
    }

    public function removeOrderDetailsReturn(OrderDetailsReturn $orderDetailsReturn): self
    {
        if ($this->orderDetailsReturns->removeElement($orderDetailsReturn)) {
            // set the owning side to null (unless already changed)
            if ($orderDetailsReturn->getMyOrderReturn() === $this) {
                $orderDetailsReturn->setMyOrderReturn(null);
            }
        }

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

    /**
     * @return Collection<int, order>
     */
    public function getMyOrder(): Collection
    {
        return $this->myOrder;
    }

    public function addMyOrder(Order $myOrder): self
    {
        if (!$this->myOrder->contains($myOrder)) {
            $this->myOrder->add($myOrder);
            $myOrder->setOrderreturn($this);
        }

        return $this;
    }

    public function removeMyOrder(Order $myOrder): self
    {
        if ($this->myOrder->removeElement($myOrder)) {
            // set the owning side to null (unless already changed)
            if ($myOrder->getOrderreturn() === $this) {
                $myOrder->setOrderreturn(null);
            }
        }

        return $this;
    }

   
}
