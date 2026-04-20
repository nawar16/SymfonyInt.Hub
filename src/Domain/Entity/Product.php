<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
class Product
{
    #[Groups(['product:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['product:read'])]
    #[ORM\Column(length: 255)]
    private string $externalId;

    #[Groups(['product:read'])]
    #[ORM\Column(length: 255)]
    private string $name;

    #[Groups(['product:read'])]
    #[ORM\Column(type: 'float')]
    private float $price;

    #[Groups(['product:read'])]
    #[ORM\Column(type: 'integer')]
    private int $stock;

    #[Groups(['product:read'])]
    #[ORM\Column(length: 50)]
    private string $source;

    #[ORM\Column(length: 20)]
    private string $syncStatus = 'pending';


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;
        return $this;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function getSource(): string
    {
        return $this->source;
    }
    public function setSource(string $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function getSyncStatus(): string
    {
        return $this->syncStatus;
    }
    public function setSyncStatus(string $syncStatus): self
    {
        $this->syncStatus = $syncStatus;
        return $this;
    }
}