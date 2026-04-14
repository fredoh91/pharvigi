<?php

namespace App\Entity;

use App\Repository\AttributionExpertsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributionExpertsRepository::class)]
class AttributionExperts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserModif = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'attributionExperts')]
    private ?ListeExperts $ListeExperts = null;

    #[ORM\ManyToOne(inversedBy: 'attributionExperts')]
    private ?AttributionCSPCasPV $AttributionCSPCasPV = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getListeExperts(): ?ListeExperts
    {
        return $this->ListeExperts;
    }

    public function setListeExperts(?ListeExperts $ListeExperts): static
    {
        $this->ListeExperts = $ListeExperts;

        return $this;
    }

    public function getAttributionCSPCasPV(): ?AttributionCSPCasPV
    {
        return $this->AttributionCSPCasPV;
    }

    public function setAttributionCSPCasPV(?AttributionCSPCasPV $AttributionCSPCasPV): static
    {
        $this->AttributionCSPCasPV = $AttributionCSPCasPV;

        return $this;
    }
}
