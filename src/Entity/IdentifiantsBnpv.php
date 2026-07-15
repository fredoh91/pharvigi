<?php

namespace App\Entity;

use App\Repository\IdentifiantsBnpvRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdentifiantsBnpvRepository::class)]
class IdentifiantsBnpv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $masterId = null;

    #[ORM\Column(nullable: true)]
    private ?int $dlpVersion = null;

    #[ORM\Column(nullable: true)]
    private ?bool $deleted = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $creationDateBnpv = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastModificationDateBnpv = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $statusDateBnpv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserModif = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'identifiantsBnpvs')]
    private ?CasPV $CasPV = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMasterId(): ?int
    {
        return $this->masterId;
    }

    public function setMasterId(?int $masterId): static
    {
        $this->masterId = $masterId;

        return $this;
    }

    public function getDlpVersion(): ?int
    {
        return $this->dlpVersion;
    }

    public function setDlpVersion(?int $dlpVersion): static
    {
        $this->dlpVersion = $dlpVersion;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCreationDateBnpv(): ?\DateTimeImmutable
    {
        return $this->creationDateBnpv;
    }

    public function setCreationDateBnpv(?\DateTimeImmutable $creationDateBnpv): static
    {
        $this->creationDateBnpv = $creationDateBnpv;

        return $this;
    }

    public function getLastModificationDateBnpv(): ?\DateTimeImmutable
    {
        return $this->lastModificationDateBnpv;
    }

    public function setLastModificationDateBnpv(?\DateTimeImmutable $lastModificationDateBnpv): static
    {
        $this->lastModificationDateBnpv = $lastModificationDateBnpv;

        return $this;
    }

    public function getStatusDateBnpv(): ?\DateTimeImmutable
    {
        return $this->statusDateBnpv;
    }

    public function setStatusDateBnpv(?\DateTimeImmutable $statusDateBnpv): static
    {
        $this->statusDateBnpv = $statusDateBnpv;

        return $this;
    }

    public function getUserCreate(): ?string
    {
        return $this->UserCreate;
    }

    public function setUserCreate(?string $UserCreate): static
    {
        $this->UserCreate = $UserCreate;

        return $this;
    }

    public function getUserModif(): ?string
    {
        return $this->UserModif;
    }

    public function setUserModif(?string $UserModif): static
    {
        $this->UserModif = $UserModif;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getCasPV(): ?CasPV
    {
        return $this->CasPV;
    }

    public function setCasPV(?CasPV $CasPV): static
    {
        $this->CasPV = $CasPV;

        return $this;
    }
}
