<?php

namespace App\Entity;

use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SellerRepository;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\EventListener\SellerListener;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Controller\ManageRequestAccountSellerController;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ApiResource(mercure: true, denormalizationContext: ['groups' => ['post']])]

#[ApiResource(operations: [
    new Post(
<<<<<<< HEAD
        uriTemplate: '/seller/{id}/request/answer',
        controller: ManageRequestAccountSellerController::class,
=======
        uriTemplate: '/seller/request/answer/{id}',
        controller: SellerRequestAnswerController::class,
>>>>>>> 8150f929beb0d867fc2a419d696fff3e5123ce8b
        name: 'seller_request_answer',
        security: 'is_granted("ROLE_SELLER")',
    )
])]
#[ORM\EntityListeners([SellerListener::class])]
#[ORM\Entity(repositoryClass: SellerRepository::class)]

class Seller implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: true)]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $shopLabel = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['post'])]
    private ?string $shopDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $shopEmailContact = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $shopPhoneContact = null;

    #[ORM\Column(nullable: true)]

    private ?bool $isActif = false;

    #[ORM\Column(nullable: true)]
   
    private ?bool $isRequested = true;

    #[ORM\OneToMany(mappedBy: 'seller', targetEntity: Product::class)]
    private Collection $items;


    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isDeclined = null;

    #[ORM\Column(nullable: true)]
    private ?int $userId = null;

   
    public function __construct()
    {
        $this->items = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopLabel(): ?string
    {
        return $this->shopLabel;
    }

    public function setShopLabel(?string $shopLabel): self
    {
        $this->shopLabel = $shopLabel;

        return $this;
    }

    public function getShopDescription(): ?string
    {
        return $this->shopDescription;
    }

    public function setShopDescription(?string $shopDescription): self
    {
        $this->shopDescription = $shopDescription;

        return $this;
    }

    public function getShopEmailContact(): ?string
    {
        return $this->shopEmailContact;
    }

    public function setShopEmailContact(?string $shopEmailContact): self
    {
        $this->shopEmailContact = $shopEmailContact;

        return $this;
    }

    public function getShopPhoneContact(): ?string
    {
        return $this->shopPhoneContact;
    }

    public function setShopPhoneContact(?string $shopPhoneContact): self
    {
        $this->shopPhoneContact = $shopPhoneContact;

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(?bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getIsRequested(): ?bool
    {
        return $this->isRequested;
    }

    public function setIsRequested(?bool $isRequested): self
    {
        $this->isRequested = $isRequested;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Product $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setSeller($this);
        }

        return $this;
    }

    public function removeItem(Product $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSeller() === $this) {
                $item->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsDeclined(): ?bool
    {
        return $this->isDeclined;
    }

    public function setIsDeclined(?bool $isDeclined): self
    {
        $this->isDeclined = $isDeclined;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

}
