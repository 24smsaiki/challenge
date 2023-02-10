<?php

namespace App\Entity;

use ApiPlatform\Metadata\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\OrderReturnController;
use App\Repository\OrderReturnRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[ApiResource(mercure: true, security: "is_granted('ROLE_USER') || is_granted('ROLE_ADMIN')", denormalizationContext: ['groups' => ['post']])]
#[ORM\Entity(repositoryClass: OrderReturnRepository::class)]

#[ApiResource(operations: [
    new Post(
        uriTemplate: '/order/create/return',
        controller: OrderReturnController::class,
        name: 'order_return'
    )
])]
class OrderReturn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Order $myOrder = null;

    #[ORM\Column(nullable: true)]
    private ?int $state = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'myOrderReturn', targetEntity: OrderDetailsReturn::class)]
    private Collection $orderDetailsReturns;

    public function __construct()
    {
        $this->orderDetailsReturns = new ArrayCollection();
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

    public function getMyOrder(): ?Order
    {
        return $this->myOrder;
    }

    public function setMyOrder(?Order $myOrder): self
    {
        $this->myOrder = $myOrder;

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
}
