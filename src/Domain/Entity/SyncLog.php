<?php

namespace App\Domain\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class SyncLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $integration;

    #[ORM\Column(length: 20)]
    private string $status;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $message = null;

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
}