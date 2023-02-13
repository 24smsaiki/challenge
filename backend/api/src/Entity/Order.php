<?php

namespace App\Entity;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\NewOrderController;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(mercure: true, denormalizationContext: ['groups' => ['post']], normalizationContext: ['groups' => ['get']])]
#[Get(security: "is_granted('ROLE_ADMIN')")]
#[GetCollection(security: "is_granted('ROLE_USER') || is_granted('ROLE_ADMIN')")]
#[Put(security: "is_granted('ROLE_ADMIN')")]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]

#[ApiResource(operations: [
    new Post(
        uriTemplate: '/order/pass',
        controller: NewOrderController::class,
        name: 'order',
        security : "is_granted('ROLE_USER')" 
    )
])]

class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post', 'get'])]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['post', 'get'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['post', 'get'])]
    private ?bool $isPaid = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['post', 'get'])]
    private ?int $state = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['post', 'get'])]
    private ?float $total = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $customer = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[Groups(['post', 'get'])]
    private ?Address $delivery = null;

    #[ORM\OneToMany(mappedBy: 'myOrder', targetEntity: OrderDetails::class)]    
    #[Groups(['post', 'get'])]
    private ?Collection $orderDetails = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripeSessionId = null;

    #[Groups(['post', 'get'])]
    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Carrier $carrier = null;

    #[ORM\OneToMany(mappedBy: 'myOrder', targetEntity: OrderReturn::class)]
    private Collection $orderreturns;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->orderreturns = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(?bool $isPaid): self
    {
        $this->isPaid = $isPaid;

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

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDelivery(): ?Address
    {
        return $this->delivery;
    }

    public function setDelivery(?Address $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetails>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setMyOrder($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getMyOrder() === $this) {
                $orderDetail->setMyOrder(null);
            }
        }

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(?string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
    }

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(?Carrier $carrier): self
    {
        $this->carrier = $carrier;

        return $this;
    }

    /**
     * @return Collection<int, Orderreturn>
     */
    public function getOrderreturns(): Collection
    {
        return $this->orderreturns;
    }

    public function addOrderreturn(OrderReturn $orderreturn): self
    {
        if (!$this->orderreturns->contains($orderreturn)) {
            $this->orderreturns->add($orderreturn);
            $orderreturn->setMyOrder($this);
        }

        return $this;
    }

    public function removeOrderreturn(OrderReturn $orderreturn): self
    {
        if ($this->orderreturns->removeElement($orderreturn)) {
            // set the owning side to null (unless already changed)
            if ($orderreturn->getMyOrder() === $this) {
                $orderreturn->setMyOrder(null);
            }
        }

        return $this;
    }
    
}
