<?php

namespace App\Entity;

use App\Entity\Product;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types; 
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SellerRepository;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\EventListener\SellerListener;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;  
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\ManageRequestAccountSellerController;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ApiResource(mercure: true, denormalizationContext: ['groups' => ['post']], normalizationContext: ['groups' => ['get']])]
#[Put(security: "(is_granted('ROLE_SELLER') and object.userId == user.id) || is_granted('ROLE_ADMIN')")]
#[Post()]
#[Delete(security: "is_granted('ROLE_ADMIN') || (is_granted('ROLE_SELLER') and object.userId == user.id)")]
#[ApiResource(operations: [
    new Post(
        uriTemplate: '/seller/request/answer/{id}',
        controller: ManageRequestAccountSellerController::class,
        name: 'seller_request_answer',
        security: 'is_granted("ROLE_ADMIN")',
    )
])]
#[GetCollection(security: "is_granted('ROLE_ADMIN')")]
#[Get(security: "(is_granted('ROLE_SELLER') and object.userId == user.id) || is_granted('ROLE_ADMIN')")]

#[UniqueEntity(fields: ['shopEmailContact'], message: 'Cet email est déjà utilisé.')]
#[ORM\EntityListeners([SellerListener::class])]
#[ORM\Entity(repositoryClass: SellerRepository::class)]

class Seller implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: true)]
    #[Groups(['get'])]
    private ?int $id = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post', 'get'])]
    private ?string $shopLabel = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['post', 'get'])]
    private ?string $shopDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post', 'get'])]
    private ?string $shopEmailContact = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post', 'get'])]
    private ?string $shopPhoneContact = null;
    
    #[Groups(['get'])]
    #[ORM\Column(nullable: true)]
    private ?bool $isActif = false;

    #[ORM\Column(nullable: true)]
    private ?bool $isRequested = true;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['post'])]
    private ?string $password = null;
    
    #[ORM\Column(nullable: true)]
    public ?int $userId = null;

    #[ORM\OneToMany(mappedBy: 'publisher', targetEntity: Product::class)]
    private Collection $products;

    #[Groups(['post', 'get'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[Groups(['post', 'get'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[Groups(['get'])]
    #[ORM\Column]
    private ?bool $is_pending = true;



    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setPublisher($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getPublisher() === $this) {
                $product->setPublisher(null);
            }
        }

        return $this;
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

    public function isIsPending(): ?bool
    {
        return $this->is_pending;
    }

    public function setIsPending(bool $is_pending): self
    {
        $this->is_pending = $is_pending;

        return $this;
    }
}
