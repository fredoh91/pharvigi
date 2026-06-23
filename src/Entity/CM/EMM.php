<?php

namespace App\Entity\CM;

use App\Repository\CM\EMMRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EMMRepository::class)]
class EMM extends \App\Entity\CasPV
{
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $avisCRPV = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $MotifNonPresentation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $suiviEnquete = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ListeCRPV = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $MaitriseRisque_Commentaire = null;

    #[ORM\OneToOne(inversedBy: 'eMM', cascade: ['persist', 'remove'])]
    private ?DonneesComplementairesEMM $DonneesComplementairesEMM = null;

    public function getAvisCRPV(): ?string
    {
        return $this->avisCRPV;
    }

    public function setAvisCRPV(?string $avisCRPV): static
    {
        $this->avisCRPV = $avisCRPV;

        return $this;
    }

    public function getMotifNonPresentation(): ?string
    {
        return $this->MotifNonPresentation;
    }

    public function setMotifNonPresentation(?string $MotifNonPresentation): static
    {
        $this->MotifNonPresentation = $MotifNonPresentation;

        return $this;
    }

    public function getSuiviEnquete(): ?string
    {
        return $this->suiviEnquete;
    }

    public function setSuiviEnquete(?string $suiviEnquete): static
    {
        $this->suiviEnquete = $suiviEnquete;

        return $this;
    }

    public function getListeCRPV(): ?string
    {
        return $this->ListeCRPV;
    }

    public function setListeCRPV(?string $ListeCRPV): static
    {
        $this->ListeCRPV = $ListeCRPV;

        return $this;
    }

    public function getMaitriseRisqueCommentaire(): ?string
    {
        return $this->MaitriseRisque_Commentaire;
    }

    public function setMaitriseRisqueCommentaire(?string $MaitriseRisque_Commentaire): static
    {
        $this->MaitriseRisque_Commentaire = $MaitriseRisque_Commentaire;

        return $this;
    }

    public function getDonneesComplementairesEMM(): ?DonneesComplementairesEMM
    {
        return $this->DonneesComplementairesEMM;
    }

    public function setDonneesComplementairesEMM(?DonneesComplementairesEMM $DonneesComplementairesEMM): static
    {
        $this->DonneesComplementairesEMM = $DonneesComplementairesEMM;

        return $this;
    }
}
