<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ]
)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: User::class)]
    private Collection $usercountry;

    public function __construct()
    {
        $this->usercountry = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsercountry(): Collection
    {
        return $this->usercountry;
    }

    public function addUsercountry(User $usercountry): static
    {
        if (!$this->usercountry->contains($usercountry)) {
            $this->usercountry->add($usercountry);
            $usercountry->setCountry($this);
        }

        return $this;
    }

    public function removeUsercountry(User $usercountry): static
    {
        if ($this->usercountry->removeElement($usercountry)) {
            // set the owning side to null (unless already changed)
            if ($usercountry->getCountry() === $this) {
                $usercountry->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}