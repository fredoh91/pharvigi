<?php

namespace App\Entity;

use App\Repository\SIMADRepository;
// use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SIMADRepository::class)]
class SIMAD extends CasPV
{
    #[ORM\Column(nullable: true)]
    private ?bool $CasImportDepuisExcel = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Divas = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Date_evenement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Date_notification = null;

    #[ORM\OneToOne(inversedBy: 'sIMAD', cascade: ['persist', 'remove'])]
    private ?DonneesComplementairesSIMAD $DonneesComplementairesSIMAD = null;

    public function isCasImportDepuisExcel(): ?bool
    {
        return $this->CasImportDepuisExcel;
    }

    public function setCasImportDepuisExcel(?bool $CasImportDepuisExcel): static
    {
        $this->CasImportDepuisExcel = $CasImportDepuisExcel;

        return $this;
    }

    public function isDivas(): ?bool
    {
        return $this->Divas;
    }

    public function setDivas(?bool $Divas): static
    {
        $this->Divas = $Divas;

        return $this;
    }

    public function getDateEvenement(): ?string
    {
        return $this->Date_evenement;
    }

    public function setDateEvenement(?string $Date_evenement): static
    {
        $this->Date_evenement = $Date_evenement;

        return $this;
    }

    public function getDateNotification(): ?string
    {
        return $this->Date_notification;
    }

    public function setDateNotification(?string $Date_notification): static
    {
        $this->Date_notification = $Date_notification;

        return $this;
    }

    public function getDonneesComplementairesSIMAD(): ?DonneesComplementairesSIMAD
    {
        return $this->DonneesComplementairesSIMAD;
    }

    public function setDonneesComplementairesSIMAD(?DonneesComplementairesSIMAD $DonneesComplementairesSIMAD): static
    {
        $this->DonneesComplementairesSIMAD = $DonneesComplementairesSIMAD;

        return $this;
    }
}
