<?php

namespace App\Entity;

use AllowDynamicProperties;
use Symfony\Component\HttpFoundation\File\File;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;


#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: ImagesRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ]

)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'read:Product'])]
    private ?int $id = null;

    #[ORM\Column(length: 191, nullable: true)]
    #[Groups(['read', 'read:Product'])]
    private ?string $link = null;
    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'link')]
    #[Groups(['read', 'read:Product'])]
    private ?File $imageFile = null;




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
    public function __toString(): string
    {
        return $this->getLink();
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updated_At = new \DateTimeImmutable();
        }
    }


}