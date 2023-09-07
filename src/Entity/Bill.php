<?php

namespace App\Entity;

use App\Repository\BillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillRepository::class)]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\OneToMany(mappedBy: 'bill', targetEntity: Product::class)]
    private Collection $productbill;

    #[ORM\ManyToOne(inversedBy: 'billpaiment')]
    private ?Paiment $paiment = null;

    #[ORM\ManyToOne(inversedBy: 'billuser')]
    private ?User $user = null;

    public function __construct()
    {
        $this->productbill = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductbill(): Collection
    {
        return $this->productbill;
    }

    public function addProductbill(Product $productbill): static
    {
        if (!$this->productbill->contains($productbill)) {
            $this->productbill->add($productbill);
            $productbill->setBill($this);
        }

        return $this;
    }

    public function removeProductbill(Product $productbill): static
    {
        if ($this->productbill->removeElement($productbill)) {
            // set the owning side to null (unless already changed)
            if ($productbill->getBill() === $this) {
                $productbill->setBill(null);
            }
        }

        return $this;
    }

    public function getPaiment(): ?Paiment
    {
        return $this->paiment;
    }

    public function setPaiment(?Paiment $paiment): static
    {
        $this->paiment = $paiment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}