<?php

namespace App\Entity\CM;

use App\Repository\CM\DonneesComplementairesCMRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonneesComplementairesCMRepository::class)]
class DonneesComplementairesCM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EI_Attendu = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EI_Inattendu = null;

    #[ORM\Column(nullable: true)]
    private ?bool $PlausibilitePharma = null;

    #[ORM\Column(nullable: true)]
    private ?bool $TabCliniInhab = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $TabCliniInhab_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ChronoEvo = null;

    #[ORM\Column(nullable: true)]
    private ?bool $SemioEvo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $SemioEvo_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ContexPriseMedic = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ContexPriseMedic_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $SeulMedicSusp = null;

    #[ORM\Column(nullable: true)]
    private ?bool $RisqueRecu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $RisqueRecu_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $AutreCasBNPV = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AutreCasBNPV_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $AutreCasVigylise = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AutreCasVigylise_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ParticulaMedic = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ParticulaMedic_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $RisqueDocuLitt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $RisqueDocuLitt_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ContextMedia = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ContextMedia_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $PersistProb = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $PersistProb_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ASMR_SMR = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ASMR_SMR_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $UtilHorsAMM_RTU_ATU = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $UtilHorsAMM_RTU_ATU_Choix = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Autre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Autre_comment = null;

    #[ORM\OneToOne(mappedBy: 'DonneesComplementairesCM', cascade: ['persist', 'remove'])]
    private ?CM $cM = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CmPourInfo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CmPourInfo_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $SignalPotentiel = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $SignalPotentiel_comment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEIAttendu(): ?bool
    {
        return $this->EI_Attendu;
    }

    public function setEIAttendu(?bool $EI_Attendu): static
    {
        $this->EI_Attendu = $EI_Attendu;

        return $this;
    }

    public function isEIInattendu(): ?bool
    {
        return $this->EI_Inattendu;
    }

    public function setEIInattendu(?bool $EI_Inattendu): static
    {
        $this->EI_Inattendu = $EI_Inattendu;

        return $this;
    }

    public function isPlausibilitePharma(): ?bool
    {
        return $this->PlausibilitePharma;
    }

    public function setPlausibilitePharma(?bool $PlausibilitePharma): static
    {
        $this->PlausibilitePharma = $PlausibilitePharma;

        return $this;
    }

    public function isTabCliniInhab(): ?bool
    {
        return $this->TabCliniInhab;
    }

    public function setTabCliniInhab(?bool $TabCliniInhab): static
    {
        $this->TabCliniInhab = $TabCliniInhab;

        return $this;
    }

    public function getTabCliniInhabComment(): ?string
    {
        return $this->TabCliniInhab_comment;
    }

    public function setTabCliniInhabComment(?string $TabCliniInhab_comment): static
    {
        $this->TabCliniInhab_comment = $TabCliniInhab_comment;

        return $this;
    }

    public function isChronoEvo(): ?bool
    {
        return $this->ChronoEvo;
    }

    public function setChronoEvo(?bool $ChronoEvo): static
    {
        $this->ChronoEvo = $ChronoEvo;

        return $this;
    }

    public function isSemioEvo(): ?bool
    {
        return $this->SemioEvo;
    }

    public function setSemioEvo(?bool $SemioEvo): static
    {
        $this->SemioEvo = $SemioEvo;

        return $this;
    }

    public function getSemioEvoComment(): ?string
    {
        return $this->SemioEvo_comment;
    }

    public function setSemioEvoComment(?string $SemioEvo_comment): static
    {
        $this->SemioEvo_comment = $SemioEvo_comment;

        return $this;
    }

    public function isContexPriseMedic(): ?bool
    {
        return $this->ContexPriseMedic;
    }

    public function setContexPriseMedic(?bool $ContexPriseMedic): static
    {
        $this->ContexPriseMedic = $ContexPriseMedic;

        return $this;
    }

    public function getContexPriseMedicComment(): ?string
    {
        return $this->ContexPriseMedic_comment;
    }

    public function setContexPriseMedicComment(?string $ContexPriseMedic_comment): static
    {
        $this->ContexPriseMedic_comment = $ContexPriseMedic_comment;

        return $this;
    }

    public function isSeulMedicSusp(): ?bool
    {
        return $this->SeulMedicSusp;
    }

    public function setSeulMedicSusp(?bool $SeulMedicSusp): static
    {
        $this->SeulMedicSusp = $SeulMedicSusp;

        return $this;
    }

    public function isRisqueRecu(): ?bool
    {
        return $this->RisqueRecu;
    }

    public function setRisqueRecu(?bool $RisqueRecu): static
    {
        $this->RisqueRecu = $RisqueRecu;

        return $this;
    }

    public function getRisqueRecuComment(): ?string
    {
        return $this->RisqueRecu_comment;
    }

    public function setRisqueRecuComment(?string $RisqueRecu_comment): static
    {
        $this->RisqueRecu_comment = $RisqueRecu_comment;

        return $this;
    }

    public function isAutreCasBNPV(): ?bool
    {
        return $this->AutreCasBNPV;
    }

    public function setAutreCasBNPV(?bool $AutreCasBNPV): static
    {
        $this->AutreCasBNPV = $AutreCasBNPV;

        return $this;
    }

    public function getAutreCasBNPVComment(): ?string
    {
        return $this->AutreCasBNPV_comment;
    }

    public function setAutreCasBNPVComment(?string $AutreCasBNPV_comment): static
    {
        $this->AutreCasBNPV_comment = $AutreCasBNPV_comment;

        return $this;
    }

    public function isAutreCasVigylise(): ?bool
    {
        return $this->AutreCasVigylise;
    }

    public function setAutreCasVigylise(?bool $AutreCasVigylise): static
    {
        $this->AutreCasVigylise = $AutreCasVigylise;

        return $this;
    }

    public function getAutreCasVigyliseComment(): ?string
    {
        return $this->AutreCasVigylise_comment;
    }

    public function setAutreCasVigyliseComment(?string $AutreCasVigylise_comment): static
    {
        $this->AutreCasVigylise_comment = $AutreCasVigylise_comment;

        return $this;
    }

    public function isParticulaMedic(): ?bool
    {
        return $this->ParticulaMedic;
    }

    public function setParticulaMedic(?bool $ParticulaMedic): static
    {
        $this->ParticulaMedic = $ParticulaMedic;

        return $this;
    }

    public function getParticulaMedicComment(): ?string
    {
        return $this->ParticulaMedic_comment;
    }

    public function setParticulaMedicComment(?string $ParticulaMedic_comment): static
    {
        $this->ParticulaMedic_comment = $ParticulaMedic_comment;

        return $this;
    }

    public function isRisqueDocuLitt(): ?bool
    {
        return $this->RisqueDocuLitt;
    }

    public function setRisqueDocuLitt(?bool $RisqueDocuLitt): static
    {
        $this->RisqueDocuLitt = $RisqueDocuLitt;

        return $this;
    }

    public function getRisqueDocuLittComment(): ?string
    {
        return $this->RisqueDocuLitt_comment;
    }

    public function setRisqueDocuLittComment(?string $RisqueDocuLitt_comment): static
    {
        $this->RisqueDocuLitt_comment = $RisqueDocuLitt_comment;

        return $this;
    }

    public function isContextMedia(): ?bool
    {
        return $this->ContextMedia;
    }

    public function setContextMedia(?bool $ContextMedia): static
    {
        $this->ContextMedia = $ContextMedia;

        return $this;
    }

    public function getContextMediaComment(): ?string
    {
        return $this->ContextMedia_comment;
    }

    public function setContextMediaComment(?string $ContextMedia_comment): static
    {
        $this->ContextMedia_comment = $ContextMedia_comment;

        return $this;
    }

    public function isPersistProb(): ?bool
    {
        return $this->PersistProb;
    }

    public function setPersistProb(?bool $PersistProb): static
    {
        $this->PersistProb = $PersistProb;

        return $this;
    }

    public function getPersistProbComment(): ?string
    {
        return $this->PersistProb_comment;
    }

    public function setPersistProbComment(?string $PersistProb_comment): static
    {
        $this->PersistProb_comment = $PersistProb_comment;

        return $this;
    }

    public function isASMRSMR(): ?bool
    {
        return $this->ASMR_SMR;
    }

    public function setASMRSMR(?bool $ASMR_SMR): static
    {
        $this->ASMR_SMR = $ASMR_SMR;

        return $this;
    }

    public function getASMRSMRComment(): ?string
    {
        return $this->ASMR_SMR_comment;
    }

    public function setASMRSMRComment(?string $ASMR_SMR_comment): static
    {
        $this->ASMR_SMR_comment = $ASMR_SMR_comment;

        return $this;
    }

    public function isUtilHorsAMMRTUATU(): ?bool
    {
        return $this->UtilHorsAMM_RTU_ATU;
    }

    public function setUtilHorsAMMRTUATU(?bool $UtilHorsAMM_RTU_ATU): static
    {
        $this->UtilHorsAMM_RTU_ATU = $UtilHorsAMM_RTU_ATU;

        return $this;
    }

    public function getUtilHorsAMMRTUATUChoix(): ?string
    {
        return $this->UtilHorsAMM_RTU_ATU_Choix;
    }

    public function setUtilHorsAMMRTUATUChoix(?string $UtilHorsAMM_RTU_ATU_Choix): static
    {
        $this->UtilHorsAMM_RTU_ATU_Choix = $UtilHorsAMM_RTU_ATU_Choix;

        return $this;
    }

    public function isAutre(): ?bool
    {
        return $this->Autre;
    }

    public function setAutre(?bool $Autre): static
    {
        $this->Autre = $Autre;

        return $this;
    }

    public function getAutreComment(): ?string
    {
        return $this->Autre_comment;
    }

    public function setAutreComment(?string $Autre_comment): static
    {
        $this->Autre_comment = $Autre_comment;

        return $this;
    }

    public function getCM(): ?CM
    {
        return $this->cM;
    }

    public function setCM(?CM $cM): static
    {
        // unset the owning side of the relation if necessary
        if ($cM === null && $this->cM !== null) {
            $this->cM->setDonneesComplementairesCM(null);
        }

        // set the owning side of the relation if necessary
        if ($cM !== null && $cM->getDonneesComplementairesCM() !== $this) {
            $cM->setDonneesComplementairesCM($this);
        }

        $this->cM = $cM;

        return $this;
    }
    public function isCmPourInfo(): ?bool
    {
        return $this->CmPourInfo;
    }

    public function setCmPourInfo(?bool $CmPourInfo): static
    {
        $this->CmPourInfo = $CmPourInfo;

        return $this;
    }

    public function getCmPourInfoComment(): ?string
    {
        return $this->CmPourInfo_comment;
    }

    public function setCmPourInfoComment(?string $CmPourInfo_comment): static
    {
        $this->CmPourInfo_comment = $CmPourInfo_comment;

        return $this;
    }

    public function isSignalPotentiel(): ?bool
    {
        return $this->SignalPotentiel;
    }

    public function setSignalPotentiel(?bool $SignalPotentiel): static
    {
        $this->SignalPotentiel = $SignalPotentiel;

        return $this;
    }

    public function getSignalPotentielComment(): ?string
    {
        return $this->SignalPotentiel_comment;
    }

    public function setSignalPotentielComment(?string $SignalPotentiel_comment): static
    {
        $this->SignalPotentiel_comment = $SignalPotentiel_comment;

        return $this;
    }
}
