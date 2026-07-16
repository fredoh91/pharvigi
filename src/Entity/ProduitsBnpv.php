<?php

namespace App\Entity;

use App\Repository\ProduitsBnpvRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitsBnpvRepository::class)]
class ProduitsBnpv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $masterId = null;

    #[ORM\Column(nullable: true)]
    private ?int $dlpVersion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productCharacterization = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productName = null;

    #[ORM\Column(nullable: true)]
    private ?int $NBBlock = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $substanceName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productIndication = null;

    #[ORM\Column(nullable: true)]
    private ?int $NBBlock2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserModif = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'produitsBnpvs')]
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

    public function getProductCharacterization(): ?string
    {
        return $this->productCharacterization;
    }

    public function setProductCharacterization(?string $productCharacterization): static
    {
        $this->productCharacterization = $productCharacterization;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    public function getNBBlock(): ?int
    {
        return $this->NBBlock;
    }

    public function setNBBlock(?int $NBBlock): static
    {
        $this->NBBlock = $NBBlock;

        return $this;
    }

    public function getSubstanceName(): ?string
    {
        return $this->substanceName;
    }

    public function setSubstanceName(?string $substanceName): static
    {
        $this->substanceName = $substanceName;

        return $this;
    }

    public function getProductIndication(): ?string
    {
        return $this->productIndication;
    }

    public function setProductIndication(?string $productIndication): static
    {
        $this->productIndication = $productIndication;

        return $this;
    }

    public function getNBBlock2(): ?int
    {
        return $this->NBBlock2;
    }

    public function setNBBlock2(?int $NBBlock2): static
    {
        $this->NBBlock2 = $NBBlock2;

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
