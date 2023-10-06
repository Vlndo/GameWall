<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['lire']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new Get(),
        new GetCollection(normalizationContext: ['groups' => ['lire:collection', 'lire:Product']]),
    ],
    // operations: [
    //     new Get(),
    //     new GetCollection()
    // ]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["lire", "lire:collection"])]
    private ?int $id = null;

    #[ORM\Column(length: 191)]
    #[Groups(["lire", "lire:collection",'read:bill','read:user'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(["lire", "lire:collection"])]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["lire", "lire:collection"])]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["lire", "lire:collection",'read:bill','read:user'])]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["lire", "lire:collection"])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["lire", "lire:collection"])]
    private ?int $rate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["lire", "lire:collection"])]
    private ?string $productcontent = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["lire", "lire:collection"])]
    private ?string $requiredspecs = null;

    #[ORM\Column(length: 191, nullable: true)]
    #[Groups(["lire", "lire:collection",'read:user'])]
    private ?string $edition = null;

    #[ORM\ManyToMany(targetEntity: Images::class, mappedBy: 'productimages')]
    #[Groups(["lire", "lire:collection",'read:bill','read:user'])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'producttag')]
    #[Groups(["lire", "lire:collection"])]
    private Collection $tags;

    #[ORM\ManyToMany(targetEntity: Platform::class, mappedBy: 'productplatform')]
    #[Groups(["lire", "lire:collection"])]
    private Collection $platforms;

    #[ORM\OneToMany(mappedBy: 'keyProduct', targetEntity: Key::class)]
    #[Groups(["lire", "lire:collection"])]
    private Collection $keeys;


    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->platforms = new ArrayCollection();
        $this->keeys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getProductcontent(): ?string
    {
        return $this->productcontent;
    }

    public function setProductcontent(?string $productcontent): static
    {
        $this->productcontent = $productcontent;

        return $this;
    }

    public function getRequiredspecs(): ?string
    {
        return $this->requiredspecs;
    }

    public function setRequiredspecs(?string $requiredspecs): static
    {
        $this->requiredspecs = $requiredspecs;

        return $this;
    }

    public function getEdition(): ?string
    {
        return $this->edition;
    }

    public function setEdition(?string $edition): static
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->addProductimage($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            $image->removeProductimage($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addProducttag($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeProducttag($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Platform>
     */
    public function getPlatforms(): Collection
    {
        return $this->platforms;
    }

    public function addPlatform(Platform $platform): static
    {
        if (!$this->platforms->contains($platform)) {
            $this->platforms->add($platform);
            $platform->addProductplatform($this);
        }

        return $this;
    }

    public function removePlatform(Platform $platform): static
    {
        if ($this->platforms->removeElement($platform)) {
            $platform->removeProductplatform($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Key>
     */
    public function getKeeys(): Collection
    {
        return $this->keeys;
    }

    public function addKeey(Key $keey): static
    {
        if (!$this->keeys->contains($keey)) {
            $this->keeys->add($keey);
            $keey->setKeyProduct($this);
        }

        return $this;
    }

    public function removeKeey(Key $keey): static
    {
        if ($this->keeys->removeElement($keey)) {
            // set the owning side to null (unless allirey changed)
            if ($keey->getKeyProduct() === $this) {
                $keey->setKeyProduct(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}