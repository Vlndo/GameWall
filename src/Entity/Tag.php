<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191)]
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
}
