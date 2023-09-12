<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\KeyRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;

#[ORM\Entity(repositoryClass: KeyRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
    ]
)]
#[ORM\Table(name: '`key`')]
class Key
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191)]
    private ?string $keyNumber = null;

    #[ORM\ManyToOne(inversedBy: 'keeys')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $keyProduct = null;

    #[ORM\ManyToOne(inversedBy: 'keeys')]
    private ?Bill $billKey = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyNumber(): ?string
    {
        return $this->keyNumber;
    }

    public function setKeyNumber(string $keyNumber): static
    {
        $this->keyNumber = $keyNumber;

        return $this;
    }

    public function getKeyProduct(): ?Product
    {
        return $this->keyProduct;
    }

    public function setKeyProduct(?Product $keyProduct): static
    {
        $this->keyProduct = $keyProduct;

        return $this;
    }

    public function getBillKey(): ?Bill
    {
        return $this->billKey;
    }

    public function setBillKey(?Bill $billKey): static
    {
        $this->billKey = $billKey;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getKeyNumber();
    }
}