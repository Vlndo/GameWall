<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['read', 'create', 'create:post'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: User::class)]
    private Collection $countryUser;


    public function __construct()
    {
        $this->countryUser = new ArrayCollection();
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

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return <int, User>
     */
    public function getCountryUser()
    {
        return $this->countryUser->getValues();
    }

    public function addCountryUser(User $countryUser): static
    {
        if (!$this->countryUser->contains($countryUser)) {
            $this->countryUser->add($countryUser);
            $countryUser->setCountry($this);
        }

        return $this;
    }

    public function removeCountryUser(User $countryUser): static
    {
        if ($this->countryUser->removeElement($countryUser)) {
            // set the owning side to null (unless already changed)
            if ($countryUser->getCountry() === $this) {
                $countryUser->setCountry(null);
            }
        }

        return $this;
    }
}