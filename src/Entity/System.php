<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SystemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: SystemRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ]
)]
#[ORM\Table(name: '`system`')]
class System
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Platform::class, inversedBy: 'systems')]
    private Collection $platfromsystem;

    public function __construct()
    {
        $this->platfromsystem = new ArrayCollection();
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
     * @return Collection<int, Platform>
     */
    public function getPlatfromsystem(): Collection
    {
        return $this->platfromsystem;
    }

    public function addPlatfromsystem(Platform $platfromsystem): static
    {
        if (!$this->platfromsystem->contains($platfromsystem)) {
            $this->platfromsystem->add($platfromsystem);
        }

        return $this;
    }

    public function removePlatfromsystem(Platform $platfromsystem): static
    {
        $this->platfromsystem->removeElement($platfromsystem);

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}