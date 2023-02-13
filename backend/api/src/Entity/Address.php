<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use App\EventListener\AddressListener;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(mercure: true,security: "is_granted('ROLE_USER') || is_granted('ROLE_ADMIN')",denormalizationContext: ['groups' => ['post']])]
#[Post(security: "is_granted('ROLE_ADMIN') || is_granted('ROLE_USER')")]
#[Get(security: "is_granted('ROLE_ADMIN') || (is_granted('ROLE_USER') and object.customer == user)")]
#[GetCollection(security: "is_granted('ROLE_ADMIN') || is_granted('ROLE_USER')")]  
#[Delete(security: "is_granted('ROLE_ADMIN') || (is_granted('ROLE_USER') and object.customer == user)")]
#[Put(security: "is_granted('ROLE_ADMIN') || (is_granted('ROLE_USER') and object.customer == user)")]    
#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\EntityListeners([AddressListener::class])]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $addressField = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $addressFieldInformation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $country = null;

    #[ORM\ManyToOne(inversedBy: 'Address')]
    #[Groups(['post'])]
    public ?User $customer = null;

    #[ORM\OneToMany(mappedBy: 'delivery', targetEntity: Order::class)]
    #[Groups(['post','get'])]
    private Collection $orders;
    #[Groups(['get'])]
    #[ORM\Column(nullable: true)]
    private ?bool $is_deleted = false;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddressField(): ?string
    {
        return $this->addressField;
    }

    public function setAddressField(?string $addressField): self
    {
        $this->addressField = $addressField;

        return $this;
    }

    public function getAddressFieldInformation(): ?string
    {
        return $this->addressFieldInformation;
    }

    public function setAddressFieldInformation(?string $addressFieldInformation): self
    {
        $this->addressFieldInformation = $addressFieldInformation;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

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

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setDelivery($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getDelivery() === $this) {
                $order->setDelivery(null);
            }
        }

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(?bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }
}
