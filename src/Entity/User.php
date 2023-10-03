<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Serializer\Annotation\Groups;
use App\State\UserPasswordHasher;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['create', 'create:post', 'create:user']],
    operations: [
        new Get(normalizationContext: ['groups' => ['read:collection', 'read:user']]),
        new Post(processor: UserPasswordHasher::class, validationContext: ['groups' => ['Default', 'create:user']]),
        new Delete(),
        new Patch(processor: UserPasswordHasher::class),
    ],
)]
class User implements
    UserInterface,
    PasswordAuthenticatedUserInterface,
    JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'read:user','read:bill'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['create', 'create:post', 'read', 'read:user','read:bill'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['read', 'read:user'])]
    private ?string $password = null;

    #[Groups(['create', 'create:post', 'create:user','read', 'read:user'])]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 191, nullable: true)]
    #[Groups(['create', 'create:post', 'read', 'read:user'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['create', 'create:post','read', 'read:user'])]
    private ?int $age = null;

    #[ORM\Column]
    #[Groups(['create', 'create:post','read', 'read:user'])]
    private ?bool $isadmin = null;

    #[ORM\Column(length: 191)]
    #[Groups(['create', 'create:post','read', 'read:user'])]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'billuser', targetEntity: Bill::class)]
    #[Groups(['read', 'read:user'])]
    private ?Collection $bills = null;

    #[ORM\ManyToOne(inversedBy: 'countryUser')]
    #[Groups(['create', 'create:post',])]
    private ?Country $country = null;

    public function __construct()
    {
        $this->bills = new ArrayCollection();
        $this->billuser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
        $roles[] = 'ROLE_USER';
        if ($this->isIsadmin()) {
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function isIsadmin(): ?bool
    {
        return $this->isadmin;
    }

    public function setIsadmin(bool $isadmin): static
    {
        if (!$isadmin) {
            $isadmin === false;
        }
        $this->isadmin = $isadmin;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getEmail();
    }

    public static function createFromPayload($username, array $payload): self
    {
        return (new self())
            ->setId($username)
            ->setRoles($payload['roles'])
            ->setEmail($payload['email'])
        ;
    }

    /**
     * @return ?Collection<int, Bill>
     */
    public function getBills(): ?Collection
    {
        return $this->bills;
    }

    public function addBill(?Bill $bill): static
    {
        if (!$this->bills->contains($bill)) {
            $this->bills->add($bill);
            $bill->setBilluser($this);
        }

        return $this;
    }

    public function removeBill(?Bill $bill): static
    {
        if ($this->bills->removeElement($bill)) {
            // set the owning side to null (unless already changed)
            if ($bill->getBilluser() === $this) {
                $bill->setBilluser(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }
}