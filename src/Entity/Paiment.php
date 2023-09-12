<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PaimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: PaimentRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ]
)]
class Paiment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'paiment', targetEntity: Bill::class)]
    private Collection $billpaiment;

    public function __construct()
    {
        $this->billpaiment = new ArrayCollection();
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
     * @return Collection<int, Bill>
     */
    public function getBillpaiment(): Collection
    {
        return $this->billpaiment;
    }

    public function addBillpaiment(Bill $billpaiment): static
    {
        if (!$this->billpaiment->contains($billpaiment)) {
            $this->billpaiment->add($billpaiment);
            $billpaiment->setPaiment($this);
        }

        return $this;
    }

    public function removeBillpaiment(Bill $billpaiment): static
    {
        if ($this->billpaiment->removeElement($billpaiment)) {
            // set the owning side to null (unless already changed)
            if ($billpaiment->getPaiment() === $this) {
                $billpaiment->setPaiment(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getName();
    }
}