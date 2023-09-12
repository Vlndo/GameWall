<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;

#[ORM\Entity(repositoryClass: BillRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
    ]
)]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $billNumber = null;


    #[ORM\ManyToOne(inversedBy: 'billpaiment')]
    private ?Paiment $paiment = null;

    #[ORM\ManyToOne(inversedBy: 'billuser')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'billKey', targetEntity: Key::class)]
    private Collection $keeys;

    // #[ORM\OneToMany(mappedBy: 'bill', targetEntity: Key::class)]
    // private Collection $billKey;

    public function __construct()
    {
        $this->productbill = new ArrayCollection();
        // $this->billKey = new ArrayCollection();
        $this->keeys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBillNumber(): ?string
    {
        return $this->billNumber;
    }

    public function setBillNumber(string $billNumber): static
    {
        $this->billNumber = $billNumber;

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
    // public function __toString(): string
    // {
    //     return $this->getUser();
    // }

    // /**
    //  * @return Collection<int, Key>
    //  */
    // public function getBillKey(): Collection
    // {
    //     return $this->billKey;
    // }

    // public function addBillKey(Key $billKey): static
    // {
    //     if (!$this->billKey->contains($billKey)) {
    //         $this->billKey->add($billKey);
    //         $billKey->setBill($this);
    //     }

    //     return $this;
    // }

    // public function removeBillKey(Key $billKey): static
    // {
    //     if ($this->billKey->removeElement($billKey)) {
    //         // set the owning side to null (unless already changed)
    //         if ($billKey->getBill() === $this) {
    //             $billKey->setBill(null);
    //         }
    //     }

    //     return $this;
    // }

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
            $keey->setBillKey($this);
        }

        return $this;
    }

    public function removeKeey(Key $keey): static
    {
        if ($this->keeys->removeElement($keey)) {
            // set the owning side to null (unless already changed)
            if ($keey->getBillKey() === $this) {
                $keey->setBillKey(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getBillNumber();
    }

}