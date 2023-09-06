<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191, nullable: true)]
    private ?string $link = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'images')]
    private Collection $productimages;

    public function __construct()
    {
        $this->productimages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductimages(): Collection
    {
        return $this->productimages;
    }

    public function addProductimage(Product $productimage): static
    {
        if (!$this->productimages->contains($productimage)) {
            $this->productimages->add($productimage);
        }

        return $this;
    }

    public function removeProductimage(Product $productimage): static
    {
        $this->productimages->removeElement($productimage);

        return $this;
    }
}
