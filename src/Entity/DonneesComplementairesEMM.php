<?php

namespace App\Entity;

use App\Repository\DonneesComplementairesEMMRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonneesComplementairesEMMRepository::class)]
class DonneesComplementairesEMM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EM_ErrAveree = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EM_ErrPotentielle = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EM_RisqueErr = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EtapeIni_Prescription = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EtapeIni_Delivrance = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EtapeIni_Admini = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EtapeIni_Prepa = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EtapeIni_NA_RisqueErr = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CauseEM_SimiDenoCom = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CauseEM_SimiComprime = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CauseEM_SimiCondPrim = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CauseEM_SimiCondExt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CauseEM_ManqueLisi = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CauseEM_InfoManquante = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CauseEM_PresInadap = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CauseEM_Autre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CauseEM_Autre_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ConseEM_aConduitEI = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ConseEM_auraitPuConduireEI = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CritAnaRisq_ProbRecu = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CritAnaRisq_Cluster = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CritAnaRisq_EMenfant = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CritAnaRisq_UsageParti = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CritAnaRisq_ContextMedia = null;

    #[ORM\OneToOne(mappedBy: 'DonneesComplementairesEMM', cascade: ['persist', 'remove'])]
    private ?EMM $eMM = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEMErrAveree(): ?bool
    {
        return $this->EM_ErrAveree;
    }

    public function setEMErrAveree(?bool $EM_ErrAveree): static
    {
        $this->EM_ErrAveree = $EM_ErrAveree;

        return $this;
    }

    public function isEMErrPotentielle(): ?bool
    {
        return $this->EM_ErrPotentielle;
    }

    public function setEMErrPotentielle(?bool $EM_ErrPotentielle): static
    {
        $this->EM_ErrPotentielle = $EM_ErrPotentielle;

        return $this;
    }

    public function isEMRisqueErr(): ?bool
    {
        return $this->EM_RisqueErr;
    }

    public function setEMRisqueErr(?bool $EM_RisqueErr): static
    {
        $this->EM_RisqueErr = $EM_RisqueErr;

        return $this;
    }

    public function isEtapeIniPrescription(): ?bool
    {
        return $this->EtapeIni_Prescription;
    }

    public function setEtapeIniPrescription(?bool $EtapeIni_Prescription): static
    {
        $this->EtapeIni_Prescription = $EtapeIni_Prescription;

        return $this;
    }

    public function isEtapeIniDelivrance(): ?bool
    {
        return $this->EtapeIni_Delivrance;
    }

    public function setEtapeIniDelivrance(?bool $EtapeIni_Delivrance): static
    {
        $this->EtapeIni_Delivrance = $EtapeIni_Delivrance;

        return $this;
    }

    public function isEtapeIniAdmini(): ?bool
    {
        return $this->EtapeIni_Admini;
    }

    public function setEtapeIniAdmini(?bool $EtapeIni_Admini): static
    {
        $this->EtapeIni_Admini = $EtapeIni_Admini;

        return $this;
    }

    public function isEtapeIniPrepa(): ?bool
    {
        return $this->EtapeIni_Prepa;
    }

    public function setEtapeIniPrepa(?bool $EtapeIni_Prepa): static
    {
        $this->EtapeIni_Prepa = $EtapeIni_Prepa;

        return $this;
    }

    public function isEtapeIniNARisqueErr(): ?bool
    {
        return $this->EtapeIni_NA_RisqueErr;
    }

    public function setEtapeIniNARisqueErr(?bool $EtapeIni_NA_RisqueErr): static
    {
        $this->EtapeIni_NA_RisqueErr = $EtapeIni_NA_RisqueErr;

        return $this;
    }

    public function isCauseEMSimiDenoCom(): ?bool
    {
        return $this->CauseEM_SimiDenoCom;
    }

    public function setCauseEMSimiDenoCom(?bool $CauseEM_SimiDenoCom): static
    {
        $this->CauseEM_SimiDenoCom = $CauseEM_SimiDenoCom;

        return $this;
    }

    public function isCauseEMSimiComprime(): ?bool
    {
        return $this->CauseEM_SimiComprime;
    }

    public function setCauseEMSimiComprime(?bool $CauseEM_SimiComprime): static
    {
        $this->CauseEM_SimiComprime = $CauseEM_SimiComprime;

        return $this;
    }

    public function isCauseEMSimiCondPrim(): ?bool
    {
        return $this->CauseEM_SimiCondPrim;
    }

    public function setCauseEMSimiCondPrim(?bool $CauseEM_SimiCondPrim): static
    {
        $this->CauseEM_SimiCondPrim = $CauseEM_SimiCondPrim;

        return $this;
    }

    public function isCauseEMSimiCondExt(): ?bool
    {
        return $this->CauseEM_SimiCondExt;
    }

    public function setCauseEMSimiCondExt(?bool $CauseEM_SimiCondExt): static
    {
        $this->CauseEM_SimiCondExt = $CauseEM_SimiCondExt;

        return $this;
    }

    public function isCauseEMManqueLisi(): ?bool
    {
        return $this->CauseEM_ManqueLisi;
    }

    public function setCauseEMManqueLisi(?bool $CauseEM_ManqueLisi): static
    {
        $this->CauseEM_ManqueLisi = $CauseEM_ManqueLisi;

        return $this;
    }

    public function isCauseEMInfoManquante(): ?bool
    {
        return $this->CauseEM_InfoManquante;
    }

    public function setCauseEMInfoManquante(?bool $CauseEM_InfoManquante): static
    {
        $this->CauseEM_InfoManquante = $CauseEM_InfoManquante;

        return $this;
    }

    public function isCauseEMPresInadap(): ?bool
    {
        return $this->CauseEM_PresInadap;
    }

    public function setCauseEMPresInadap(?bool $CauseEM_PresInadap): static
    {
        $this->CauseEM_PresInadap = $CauseEM_PresInadap;

        return $this;
    }

    public function isCauseEMAutre(): ?bool
    {
        return $this->CauseEM_Autre;
    }

    public function setCauseEMAutre(?bool $CauseEM_Autre): static
    {
        $this->CauseEM_Autre = $CauseEM_Autre;

        return $this;
    }

    public function getCauseEMAutreComment(): ?string
    {
        return $this->CauseEM_Autre_comment;
    }

    public function setCauseEMAutreComment(?string $CauseEM_Autre_comment): static
    {
        $this->CauseEM_Autre_comment = $CauseEM_Autre_comment;

        return $this;
    }

    public function isConseEMAConduitEI(): ?bool
    {
        return $this->ConseEM_aConduitEI;
    }

    public function setConseEMAConduitEI(?bool $ConseEM_aConduitEI): static
    {
        $this->ConseEM_aConduitEI = $ConseEM_aConduitEI;

        return $this;
    }

    public function isConseEMAuraitPuConduireEI(): ?bool
    {
        return $this->ConseEM_auraitPuConduireEI;
    }

    public function setConseEMAuraitPuConduireEI(?bool $ConseEM_auraitPuConduireEI): static
    {
        $this->ConseEM_auraitPuConduireEI = $ConseEM_auraitPuConduireEI;

        return $this;
    }

    public function isCritAnaRisqProbRecu(): ?bool
    {
        return $this->CritAnaRisq_ProbRecu;
    }

    public function setCritAnaRisqProbRecu(?bool $CritAnaRisq_ProbRecu): static
    {
        $this->CritAnaRisq_ProbRecu = $CritAnaRisq_ProbRecu;

        return $this;
    }

    public function isCritAnaRisqCluster(): ?bool
    {
        return $this->CritAnaRisq_Cluster;
    }

    public function setCritAnaRisqCluster(?bool $CritAnaRisq_Cluster): static
    {
        $this->CritAnaRisq_Cluster = $CritAnaRisq_Cluster;

        return $this;
    }

    public function isCritAnaRisqEMenfant(): ?bool
    {
        return $this->CritAnaRisq_EMenfant;
    }

    public function setCritAnaRisqEMenfant(?bool $CritAnaRisq_EMenfant): static
    {
        $this->CritAnaRisq_EMenfant = $CritAnaRisq_EMenfant;

        return $this;
    }

    public function isCritAnaRisqUsageParti(): ?bool
    {
        return $this->CritAnaRisq_UsageParti;
    }

    public function setCritAnaRisqUsageParti(?bool $CritAnaRisq_UsageParti): static
    {
        $this->CritAnaRisq_UsageParti = $CritAnaRisq_UsageParti;

        return $this;
    }

    public function isCritAnaRisqContextMedia(): ?bool
    {
        return $this->CritAnaRisq_ContextMedia;
    }

    public function setCritAnaRisqContextMedia(?bool $CritAnaRisq_ContextMedia): static
    {
        $this->CritAnaRisq_ContextMedia = $CritAnaRisq_ContextMedia;

        return $this;
    }

    public function getEMM(): ?EMM
    {
        return $this->eMM;
    }

    public function setEMM(?EMM $eMM): static
    {
        // unset the owning side of the relation if necessary
        if ($eMM === null && $this->eMM !== null) {
            $this->eMM->setDonneesComplementairesEMM(null);
        }

        // set the owning side of the relation if necessary
        if ($eMM !== null && $eMM->getDonneesComplementairesEMM() !== $this) {
            $eMM->setDonneesComplementairesEMM($this);
        }

        $this->eMM = $eMM;

        return $this;
    }
}
