<?php

namespace App\Domain\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
class SyncLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['synclog:read'])]
    #[ORM\Column(length: 50)]
    private string $integration;

    #[Groups(['synclog:read'])]
    #[ORM\Column(length: 20)]
    private string $status;

    #[Groups(['synclog:read'])]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $message = null;

    #[Groups(['synclog:read'])]
    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }
    public function setIntegration(string $integration): self
    {
        $this->integration = $integration;
        return $this;
    }
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }
    public function getIntegration(): ?string
    {
        return $this->integration;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function getMessage(): ?string
    {
        return $this->message;
    }
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }
}