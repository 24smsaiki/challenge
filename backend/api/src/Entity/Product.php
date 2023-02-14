<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use App\EventListener\ProductListener;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(mercure: true, denormalizationContext: ['groups' => ['post']], normalizationContext: ['groups' => ['get']])]
#[Get(security: "is_granted('ROLE_ADMIN')")]
#[GetCollection()]
#[Post(security: "is_granted('ROLE_SELLER') || is_granted('ROLE_ADMIN')")]
#[Put(security: "is_granted('ROLE_SELLER') || is_granted('ROLE_ADMIN')")]
#[Delete(security: "is_granted('ROLE_SELLER') || is_granted('ROLE_ADMIN')")]

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\EntityListeners([ProductListener::class])]

class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('get')]
    private ?int $id = null;

    #[Groups(['post', 'get'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[Groups(['post', 'get'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Groups(['post', 'get'])]
    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[Groups(['post'])]
    #[ORM\OneToMany(mappedBy: 'item', targetEntity: OrderDetails::class)]
    private Collection $orderDetails;

    #[Groups(['post'])]
    #[ORM\OneToMany(mappedBy: 'item', targetEntity: OrderDetailsReturn::class)]
    private Collection $orderDetailsReturns;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?seller $publisher = null;

    #[Groups(['get'])]
    #[ORM\Column(nullable: true)]
    private ?int $stockQuantity = null;

    # vérifier le problème l'extension Product ne renvoi pas ce qu'il faut  : message derreur undefined array key 'item'


    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->orderDetailsReturns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

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
            $orderDetail->setItem($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getItem() === $this) {
                $orderDetail->setItem(null);
            }
        }

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
            $orderDetailsReturn->setItem($this);
        }

        return $this;
    }

    public function removeOrderDetailsReturn(OrderDetailsReturn $orderDetailsReturn): self
    {
        if ($this->orderDetailsReturns->removeElement($orderDetailsReturn)) {
            // set the owning side to null (unless already changed)
            if ($orderDetailsReturn->getItem() === $this) {
                $orderDetailsReturn->setItem(null);
            }
        }

        return $this;
    }

    public function getPublisher(): ?seller
    {
        return $this->publisher;
    }

    public function setPublisher(?seller $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(?int $stockQuantity): self
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }
}
