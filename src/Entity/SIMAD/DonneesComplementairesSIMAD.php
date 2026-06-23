<?php

namespace App\Entity\SIMAD;

use App\Repository\SIMAD\DonneesComplementairesSIMADRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonneesComplementairesSIMADRepository::class)]
class DonneesComplementairesSIMAD
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

    #[ORM\OneToOne(mappedBy: 'DonneesComplementairesSIMAD', cascade: ['persist', 'remove'])]
    private ?SIMAD $sIMAD = null;

    #[ORM\Column(nullable: true)]
    private ?bool $NouvSubst = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $NouvSubst_comment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LettreLogigramme = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LetLogi_A = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LetLogi_B = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LetLogi_C = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LetLogi_D = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LetLogi_E = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LetLogi_F = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LetLogi_G = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LetLogi_H = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $EffetObserve = null;

    #[ORM\Column(nullable: true)]
    private ?bool $TabClinNouv = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $TabClinNouv_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ContextParticu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ContextParticu_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Cluster = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Cluster_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $PopRisk = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $PopRisk_comment = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $InfoComplement = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ConfAna = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ConfAna_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $VolRisk = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $VolRisk_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $AutCasBNPV = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AutCasBNPV_OuiNon = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AutCasBNPV_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $RechRappAnn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $RechRappAnn_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ContextSensi = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ContextSensi_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $PersistProb_mes = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $PersistProb_mes_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $SubAssocInteret = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $SubAssocInteret_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $AutDonnees = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AutDonnees_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $AvisCEIP_A = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AvisCEIP_A_comment = null;

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

    public function getSIMAD(): ?SIMAD
    {
        return $this->sIMAD;
    }

    public function setSIMAD(?SIMAD $sIMAD): static
    {
        // unset the owning side of the relation if necessary
        if ($sIMAD === null && $this->sIMAD !== null) {
            $this->sIMAD->setDonneesComplementairesSIMAD(null);
        }

        // set the owning side of the relation if necessary
        if ($sIMAD !== null && $sIMAD->getDonneesComplementairesSIMAD() !== $this) {
            $sIMAD->setDonneesComplementairesSIMAD($this);
        }

        $this->sIMAD = $sIMAD;

        return $this;
    }

    public function isNouvSubst(): ?bool
    {
        return $this->NouvSubst;
    }

    public function setNouvSubst(?bool $NouvSubst): static
    {
        $this->NouvSubst = $NouvSubst;

        return $this;
    }

    public function getNouvSubstComment(): ?string
    {
        return $this->NouvSubst_comment;
    }

    public function setNouvSubstComment(?string $NouvSubst_comment): static
    {
        $this->NouvSubst_comment = $NouvSubst_comment;

        return $this;
    }

    public function getLettreLogigramme(): ?string
    {
        return $this->LettreLogigramme;
    }

    public function setLettreLogigramme(?string $LettreLogigramme): static
    {
        $this->LettreLogigramme = $LettreLogigramme;

        return $this;
    }

    public function isLetLogiA(): ?bool
    {
        return $this->LetLogi_A;
    }

    public function setLetLogiA(?bool $LetLogi_A): static
    {
        $this->LetLogi_A = $LetLogi_A;

        return $this;
    }

    public function isLetLogiB(): ?bool
    {
        return $this->LetLogi_B;
    }

    public function setLetLogiB(?bool $LetLogi_B): static
    {
        $this->LetLogi_B = $LetLogi_B;

        return $this;
    }

    public function isLetLogiC(): ?bool
    {
        return $this->LetLogi_C;
    }

    public function setLetLogiC(?bool $LetLogi_C): static
    {
        $this->LetLogi_C = $LetLogi_C;

        return $this;
    }

    public function isLetLogiD(): ?bool
    {
        return $this->LetLogi_D;
    }

    public function setLetLogiD(?bool $LetLogi_D): static
    {
        $this->LetLogi_D = $LetLogi_D;

        return $this;
    }

    public function isLetLogiE(): ?bool
    {
        return $this->LetLogi_E;
    }

    public function setLetLogiE(?bool $LetLogi_E): static
    {
        $this->LetLogi_E = $LetLogi_E;

        return $this;
    }

    public function isLetLogiF(): ?bool
    {
        return $this->LetLogi_F;
    }

    public function setLetLogiF(?bool $LetLogi_F): static
    {
        $this->LetLogi_F = $LetLogi_F;

        return $this;
    }

    public function isLetLogiG(): ?bool
    {
        return $this->LetLogi_G;
    }

    public function setLetLogiG(?bool $LetLogi_G): static
    {
        $this->LetLogi_G = $LetLogi_G;

        return $this;
    }

    public function isLetLogiH(): ?bool
    {
        return $this->LetLogi_H;
    }

    public function setLetLogiH(?bool $LetLogi_H): static
    {
        $this->LetLogi_H = $LetLogi_H;

        return $this;
    }

    public function getEffetObserve(): ?string
    {
        return $this->EffetObserve;
    }

    public function setEffetObserve(?string $EffetObserve): static
    {
        $this->EffetObserve = $EffetObserve;

        return $this;
    }

    public function isTabClinNouv(): ?bool
    {
        return $this->TabClinNouv;
    }

    public function setTabClinNouv(?bool $TabClinNouv): static
    {
        $this->TabClinNouv = $TabClinNouv;

        return $this;
    }

    public function getTabClinNouvComment(): ?string
    {
        return $this->TabClinNouv_comment;
    }

    public function setTabClinNouvComment(?string $TabClinNouv_comment): static
    {
        $this->TabClinNouv_comment = $TabClinNouv_comment;

        return $this;
    }

    public function isContextParticu(): ?bool
    {
        return $this->ContextParticu;
    }

    public function setContextParticu(?bool $ContextParticu): static
    {
        $this->ContextParticu = $ContextParticu;

        return $this;
    }

    public function getContextParticuComment(): ?string
    {
        return $this->ContextParticu_comment;
    }

    public function setContextParticuComment(?string $ContextParticu_comment): static
    {
        $this->ContextParticu_comment = $ContextParticu_comment;

        return $this;
    }

    public function isCluster(): ?bool
    {
        return $this->Cluster;
    }

    public function setCluster(?bool $Cluster): static
    {
        $this->Cluster = $Cluster;

        return $this;
    }

    public function getClusterComment(): ?string
    {
        return $this->Cluster_comment;
    }

    public function setClusterComment(?string $Cluster_comment): static
    {
        $this->Cluster_comment = $Cluster_comment;

        return $this;
    }

    public function isPopRisk(): ?bool
    {
        return $this->PopRisk;
    }

    public function setPopRisk(?bool $PopRisk): static
    {
        $this->PopRisk = $PopRisk;

        return $this;
    }

    public function getPopRiskComment(): ?string
    {
        return $this->PopRisk_comment;
    }

    public function setPopRiskComment(?string $PopRisk_comment): static
    {
        $this->PopRisk_comment = $PopRisk_comment;

        return $this;
    }

    public function getInfoComplement(): ?string
    {
        return $this->InfoComplement;
    }

    public function setInfoComplement(?string $InfoComplement): static
    {
        $this->InfoComplement = $InfoComplement;

        return $this;
    }

    public function isConfAna(): ?bool
    {
        return $this->ConfAna;
    }

    public function setConfAna(?bool $ConfAna): static
    {
        $this->ConfAna = $ConfAna;

        return $this;
    }

    public function getConfAnaComment(): ?string
    {
        return $this->ConfAna_comment;
    }

    public function setConfAnaComment(?string $ConfAna_comment): static
    {
        $this->ConfAna_comment = $ConfAna_comment;

        return $this;
    }

    public function isVolRisk(): ?bool
    {
        return $this->VolRisk;
    }

    public function setVolRisk(?bool $VolRisk): static
    {
        $this->VolRisk = $VolRisk;

        return $this;
    }

    public function getVolRiskComment(): ?string
    {
        return $this->VolRisk_comment;
    }

    public function setVolRiskComment(?string $VolRisk_comment): static
    {
        $this->VolRisk_comment = $VolRisk_comment;

        return $this;
    }

    public function isAutCasBNPV(): ?bool
    {
        return $this->AutCasBNPV;
    }

    public function setAutCasBNPV(?bool $AutCasBNPV): static
    {
        $this->AutCasBNPV = $AutCasBNPV;

        return $this;
    }

    public function getAutCasBNPVOuiNon(): ?string
    {
        return $this->AutCasBNPV_OuiNon;
    }

    public function setAutCasBNPVOuiNon(?string $AutCasBNPV_OuiNon): static
    {
        $this->AutCasBNPV_OuiNon = $AutCasBNPV_OuiNon;

        return $this;
    }

    public function getAutCasBNPVComment(): ?string
    {
        return $this->AutCasBNPV_comment;
    }

    public function setAutCasBNPVComment(?string $AutCasBNPV_comment): static
    {
        $this->AutCasBNPV_comment = $AutCasBNPV_comment;

        return $this;
    }

    public function isRechRappAnn(): ?bool
    {
        return $this->RechRappAnn;
    }

    public function setRechRappAnn(?bool $RechRappAnn): static
    {
        $this->RechRappAnn = $RechRappAnn;

        return $this;
    }

    public function getRechRappAnnComment(): ?string
    {
        return $this->RechRappAnn_comment;
    }

    public function setRechRappAnnComment(?string $RechRappAnn_comment): static
    {
        $this->RechRappAnn_comment = $RechRappAnn_comment;

        return $this;
    }

    public function isContextSensi(): ?bool
    {
        return $this->ContextSensi;
    }

    public function setContextSensi(?bool $ContextSensi): static
    {
        $this->ContextSensi = $ContextSensi;

        return $this;
    }

    public function getContextSensiComment(): ?string
    {
        return $this->ContextSensi_comment;
    }

    public function setContextSensiComment(?string $ContextSensi_comment): static
    {
        $this->ContextSensi_comment = $ContextSensi_comment;

        return $this;
    }

    public function isPersistProbMes(): ?bool
    {
        return $this->PersistProb_mes;
    }

    public function setPersistProbMes(?bool $PersistProb_mes): static
    {
        $this->PersistProb_mes = $PersistProb_mes;

        return $this;
    }

    public function getPersistProbMesComment(): ?string
    {
        return $this->PersistProb_mes_comment;
    }

    public function setPersistProbMesComment(?string $PersistProb_mes_comment): static
    {
        $this->PersistProb_mes_comment = $PersistProb_mes_comment;

        return $this;
    }

    public function isSubAssocInteret(): ?bool
    {
        return $this->SubAssocInteret;
    }

    public function setSubAssocInteret(?bool $SubAssocInteret): static
    {
        $this->SubAssocInteret = $SubAssocInteret;

        return $this;
    }

    public function getSubAssocInteretComment(): ?string
    {
        return $this->SubAssocInteret_comment;
    }

    public function setSubAssocInteretComment(?string $SubAssocInteret_comment): static
    {
        $this->SubAssocInteret_comment = $SubAssocInteret_comment;

        return $this;
    }

    public function isAutDonnees(): ?bool
    {
        return $this->AutDonnees;
    }

    public function setAutDonnees(?bool $AutDonnees): static
    {
        $this->AutDonnees = $AutDonnees;

        return $this;
    }

    public function getAutDonneesComment(): ?string
    {
        return $this->AutDonnees_comment;
    }

    public function setAutDonneesComment(?string $AutDonnees_comment): static
    {
        $this->AutDonnees_comment = $AutDonnees_comment;

        return $this;
    }

    public function isAvisCEIPA(): ?bool
    {
        return $this->AvisCEIP_A;
    }

    public function setAvisCEIPA(?bool $AvisCEIP_A): static
    {
        $this->AvisCEIP_A = $AvisCEIP_A;

        return $this;
    }

    public function getAvisCEIPAComment(): ?string
    {
        return $this->AvisCEIP_A_comment;
    }

    public function setAvisCEIPAComment(?string $AvisCEIP_A_comment): static
    {
        $this->AvisCEIP_A_comment = $AvisCEIP_A_comment;

        return $this;
    }

}
