<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\RegisterController;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Controller\ManageProfileClientController;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ApiResource(mercure: true, denormalizationContext: ['groups' => 'post'], normalizationContext: ['groups' => 'get'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[Get(security : "(is_granted('ROLE_USER') and object == user) || is_granted('ROLE_ADMIN')")]
#[Delete(security : "ROLE_ADMIN")]
#[Post(security : "ROLE_ADMIN")]
#[Put(security : "ROLE_ADMIN")]
#[GetCollection("is_granted('ROLE_ADMIN')")]
#[Post(security : "is_granted('ROLE_ADMIN')")]
#[ApiResource(operations: [
    new Post(
        name: 'register',
        uriTemplate: '/register',
        controller: RegisterController::class
    ),
    new Post(
        name: 'updateprofile',
        uriTemplate: '/users/updateprofile',
        controller: ManageProfileClientController::class,
        security: 'is_granted("ROLE_USER")',
    )
])]


#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['post', 'get'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[Groups(['post', 'get'])]
    #[NotBlank(message: 'Veuillez renseigner l\'email'), Email(message: 'Veuillez renseigner un email valide.')]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email;

    #[Groups(['post', 'get'])]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Groups(['post'])]
    #[ApiProperty(security: "is_granted('ROLE_ADMIN')")]
    #[ORM\Column]
    #[NotBlank(message: 'Le mot de passe ne peut pas être vide.')]
    private ?string $password;

    #[Groups(['post', 'get'])]
    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Address::class)]
    private Collection $Address;

    #[Groups(['post', 'get'])]
    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token;

    #[Groups(['post', 'get'])]
    #[ORM\Column(nullable: true)]
    private ?bool $isPasswordRequest = null;

    #[Groups(['post', 'get'])]
    #[ORM\Column(nullable: true)]
    private ?bool $isActif = null;

    #[Groups(['post', 'get'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[Groups(['post', 'get'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;


    public function __construct()
    {
        $this->Address = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->Address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->Address->contains($address)) {
            $this->Address->add($address);
            $address->setCustomer($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->Address->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getCustomer() === $this) {
                $address->setCustomer(null);
            }
        }

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
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {

        $this->token = $token;

        return $this;
    }



    public function getIsPasswordRequest(): ?bool
    {
        return $this->isPasswordRequest;
    }

    public function setIsPasswordRequest(?bool $isPasswordRequest): self
    {
        $this->isPasswordRequest = $isPasswordRequest;

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
}
