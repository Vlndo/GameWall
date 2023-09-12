<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlatformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: PlatformRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ]
)]
class Platform
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'platforms')]
    private Collection $productplatform;

    #[ORM\ManyToMany(targetEntity: System::class, mappedBy: 'platfromsystem')]
    private Collection $systems;

    public function __construct()
    {
        $this->productplatform = new ArrayCollection();
        $this->systems = new ArrayCollection();
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
     * @return Collection<int, Product>
     */
    public function getProductplatform(): Collection
    {
        return $this->productplatform;
    }

    public function addProductplatform(Product $productplatform): static
    {
        if (!$this->productplatform->contains($productplatform)) {
            $this->productplatform->add($productplatform);
        }

        return $this;
    }

    public function removeProductplatform(Product $productplatform): static
    {
        $this->productplatform->removeElement($productplatform);

        return $this;
    }

    /**
     * @return Collection<int, System>
     */
    public function getSystems(): Collection
    {
        return $this->systems;
    }

    public function addSystem(System $system): static
    {
        if (!$this->systems->contains($system)) {
            $this->systems->add($system);
            $system->addPlatfromsystem($this);
        }

        return $this;
    }

    public function removeSystem(System $system): static
    {
        if ($this->systems->removeElement($system)) {
            $system->removePlatfromsystem($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}