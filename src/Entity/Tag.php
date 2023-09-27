<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ]
)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['lire', 'lire:Product'])]
    private ?int $id = null;

    #[ORM\Column(length: 191)]
    #[Groups(['lire', 'lire:Product'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'tags')]
    private Collection $producttag;

    public function __construct()
    {
        $this->producttag = new ArrayCollection();
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
    public function getProducttag(): Collection
    {
        return $this->producttag;
    }

    public function addProducttag(Product $producttag): static
    {
        if (!$this->producttag->contains($producttag)) {
            $this->producttag->add($producttag);
        }

        return $this;
    }

    public function removeProducttag(Product $producttag): static
    {
        $this->producttag->removeElement($producttag);

        return $this;
    }
    public function __toString(): string
    {
        return $this->getName();
    }
}