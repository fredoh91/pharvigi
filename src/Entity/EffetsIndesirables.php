<?php

namespace App\Entity;

use App\Repository\EffetsIndesirablesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EffetsIndesirablesRepository::class)]
class EffetsIndesirables
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $LLT_Code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LLT_Terme = null;

    #[ORM\Column(nullable: true)]
    private ?int $PT_Code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PT_Terme = null;

    #[ORM\Column(nullable: true)]
    private ?int $HLT_Code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $HLT_Terme = null;

    #[ORM\Column(nullable: true)]
    private ?int $HLGT_Code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $HLGT_Terme = null;

    #[ORM\Column(nullable: true)]
    private ?int $SOC_Code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $SOC_Terme = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $MedDRA_Ver = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $LLT_Terme_En = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $PT_Terme_En = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $HLT_Terme_En = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $HLGT_Terme_En = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $SOC_Terme_En = null;

    #[ORM\ManyToOne(inversedBy: 'effetsIndesirables')]
    private ?CasPV $CasPV = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserModif = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLLTCode(): ?int
    {
        return $this->LLT_Code;
    }

    public function setLLTCode(?int $LLT_Code): static
    {
        $this->LLT_Code = $LLT_Code;

        return $this;
    }

    public function getLLTTerme(): ?string
    {
        return $this->LLT_Terme;
    }

    public function setLLTTerme(?string $LLT_Terme): static
    {
        $this->LLT_Terme = $LLT_Terme;

        return $this;
    }

    public function getPTCode(): ?int
    {
        return $this->PT_Code;
    }

    public function setPTCode(?int $PT_Code): static
    {
        $this->PT_Code = $PT_Code;

        return $this;
    }

    public function getPTTerme(): ?string
    {
        return $this->PT_Terme;
    }

    public function setPTTerme(?string $PT_Terme): static
    {
        $this->PT_Terme = $PT_Terme;

        return $this;
    }

    public function getHLTCode(): ?int
    {
        return $this->HLT_Code;
    }

    public function setHLTCode(?int $HLT_Code): static
    {
        $this->HLT_Code = $HLT_Code;

        return $this;
    }

    public function getHLTTerme(): ?string
    {
        return $this->HLT_Terme;
    }

    public function setHLTTerme(?string $HLT_Terme): static
    {
        $this->HLT_Terme = $HLT_Terme;

        return $this;
    }

    public function getHLGTCode(): ?int
    {
        return $this->HLGT_Code;
    }

    public function setHLGTCode(?int $HLGT_Code): static
    {
        $this->HLGT_Code = $HLGT_Code;

        return $this;
    }

    public function getHLGTTerme(): ?string
    {
        return $this->HLGT_Terme;
    }

    public function setHLGTTerme(?string $HLGT_Terme): static
    {
        $this->HLGT_Terme = $HLGT_Terme;

        return $this;
    }

    public function getSOCCode(): ?int
    {
        return $this->SOC_Code;
    }

    public function setSOCCode(?int $SOC_Code): static
    {
        $this->SOC_Code = $SOC_Code;

        return $this;
    }

    public function getSOCTerme(): ?string
    {
        return $this->SOC_Terme;
    }

    public function setSOCTerme(?string $SOC_Terme): static
    {
        $this->SOC_Terme = $SOC_Terme;

        return $this;
    }

    public function getMedDRAVer(): ?string
    {
        return $this->MedDRA_Ver;
    }

    public function setMedDRAVer(?string $MedDRA_Ver): static
    {
        $this->MedDRA_Ver = $MedDRA_Ver;

        return $this;
    }

    public function getLLTTermeEn(): ?string
    {
        return $this->LLT_Terme_En;
    }

    public function setLLTTermeEn(?string $LLT_Terme_En): static
    {
        $this->LLT_Terme_En = $LLT_Terme_En;

        return $this;
    }

    public function getPTTermeEn(): ?string
    {
        return $this->PT_Terme_En;
    }

    public function setPTTermeEn(?string $PT_Terme_En): static
    {
        $this->PT_Terme_En = $PT_Terme_En;

        return $this;
    }

    public function getHLTTermeEn(): ?string
    {
        return $this->HLT_Terme_En;
    }

    public function setHLTTermeEn(?string $HLT_Terme_En): static
    {
        $this->HLT_Terme_En = $HLT_Terme_En;

        return $this;
    }

    public function getHLGTTermeEn(): ?string
    {
        return $this->HLGT_Terme_En;
    }

    public function setHLGTTermeEn(?string $HLGT_Terme_En): static
    {
        $this->HLGT_Terme_En = $HLGT_Terme_En;

        return $this;
    }

    public function getSOCTermeEn(): ?string
    {
        return $this->SOC_Terme_En;
    }

    public function setSOCTermeEn(?string $SOC_Terme_En): static
    {
        $this->SOC_Terme_En = $SOC_Terme_En;

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
}
