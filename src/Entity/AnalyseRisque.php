<?php

namespace App\Entity;

use App\Repository\AnalyseRisqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyseRisqueRepository::class)]
class AnalyseRisque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibCritereGravite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibCritereInhab = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibTypePopulation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibSuiteJud = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibMediatisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibProbSensTutelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibProbSensPartenaires = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibProduitSurveillance = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ProdSurv_SurvRenforcee = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ProdSurv_Enquete = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ProdSurv_ATU_RTU = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentCritereInhab = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentContexte = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentProduitSurveillance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibPopulationExposee = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentPopulationExposee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibDasBnpv = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentDasBnpv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibErmr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentErmr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibAutreCas = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentAutreCas = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LibSigEu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentSigEu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentGeneral = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserModif = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $DateCalcul = null;

    #[ORM\Column(nullable: true)]
    private ?int $CritereGravite_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $CritereGravite_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $CarInhabituel_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $CarInhabituel_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $TypePopulation_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $TypePopulation_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $SuiteJud_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $SuiteJud_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $Mediatisation_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $Mediatisation_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $ProbSensTutelle_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $ProbSensTutelle_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $ProbSensPartenaires_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $ProbSensPartenaires_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $ProduitSurveillance_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $ProduitSurveillance_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $PopulationExposee_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $PopulationExposee_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $DASBNPV_eRMR_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $DASBNPV_eRMR_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $CM_SigEU_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $CM_SigEU_Poids = null;

    #[ORM\Column(nullable: true)]
    private ?int $ScoreHR = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveauRisqueCalcule = null;

    #[ORM\Column(nullable: true)]
    private ?int $OccurenceEM_Score = null;

    #[ORM\Column(nullable: true)]
    private ?int $OccurenceEM_Poids = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CommentaireDMM = null;

    #[ORM\OneToOne(inversedBy: 'analyseRisque', cascade: ['persist', 'remove'])]
    private ?Produits $Produits = null;

    #[ORM\ManyToOne(inversedBy: 'analyseRisques')]
    private ?CasPV $CasPV = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibCritereGravite(): ?string
    {
        return $this->LibCritereGravite;
    }

    public function setLibCritereGravite(?string $LibCritereGravite): static
    {
        $this->LibCritereGravite = $LibCritereGravite;

        return $this;
    }

    public function getLibCritereInhab(): ?string
    {
        return $this->LibCritereInhab;
    }

    public function setLibCritereInhab(?string $LibCritereInhab): static
    {
        $this->LibCritereInhab = $LibCritereInhab;

        return $this;
    }

    public function getLibTypePopulation(): ?string
    {
        return $this->LibTypePopulation;
    }

    public function setLibTypePopulation(?string $LibTypePopulation): static
    {
        $this->LibTypePopulation = $LibTypePopulation;

        return $this;
    }

    public function getLibSuiteJud(): ?string
    {
        return $this->LibSuiteJud;
    }

    public function setLibSuiteJud(?string $LibSuiteJud): static
    {
        $this->LibSuiteJud = $LibSuiteJud;

        return $this;
    }

    public function getLibMediatisation(): ?string
    {
        return $this->LibMediatisation;
    }

    public function setLibMediatisation(?string $LibMediatisation): static
    {
        $this->LibMediatisation = $LibMediatisation;

        return $this;
    }

    public function getLibProbSensTutelle(): ?string
    {
        return $this->LibProbSensTutelle;
    }

    public function setLibProbSensTutelle(?string $LibProbSensTutelle): static
    {
        $this->LibProbSensTutelle = $LibProbSensTutelle;

        return $this;
    }

    public function getLibProbSensPartenaires(): ?string
    {
        return $this->LibProbSensPartenaires;
    }

    public function setLibProbSensPartenaires(?string $LibProbSensPartenaires): static
    {
        $this->LibProbSensPartenaires = $LibProbSensPartenaires;

        return $this;
    }

    public function getLibProduitSurveillance(): ?string
    {
        return $this->LibProduitSurveillance;
    }

    public function setLibProduitSurveillance(?string $LibProduitSurveillance): static
    {
        $this->LibProduitSurveillance = $LibProduitSurveillance;

        return $this;
    }

    public function isProdSurvSurvRenforcee(): ?bool
    {
        return $this->ProdSurv_SurvRenforcee;
    }

    public function setProdSurvSurvRenforcee(?bool $ProdSurv_SurvRenforcee): static
    {
        $this->ProdSurv_SurvRenforcee = $ProdSurv_SurvRenforcee;

        return $this;
    }

    public function isProdSurvEnquete(): ?bool
    {
        return $this->ProdSurv_Enquete;
    }

    public function setProdSurvEnquete(?bool $ProdSurv_Enquete): static
    {
        $this->ProdSurv_Enquete = $ProdSurv_Enquete;

        return $this;
    }

    public function isProdSurvATURTU(): ?bool
    {
        return $this->ProdSurv_ATU_RTU;
    }

    public function setProdSurvATURTU(?bool $ProdSurv_ATU_RTU): static
    {
        $this->ProdSurv_ATU_RTU = $ProdSurv_ATU_RTU;

        return $this;
    }

    public function getCommentCritereInhab(): ?string
    {
        return $this->CommentCritereInhab;
    }

    public function setCommentCritereInhab(?string $CommentCritereInhab): static
    {
        $this->CommentCritereInhab = $CommentCritereInhab;

        return $this;
    }

    public function getCommentContexte(): ?string
    {
        return $this->CommentContexte;
    }

    public function setCommentContexte(?string $CommentContexte): static
    {
        $this->CommentContexte = $CommentContexte;

        return $this;
    }

    public function getCommentProduitSurveillance(): ?string
    {
        return $this->CommentProduitSurveillance;
    }

    public function setCommentProduitSurveillance(?string $CommentProduitSurveillance): static
    {
        $this->CommentProduitSurveillance = $CommentProduitSurveillance;

        return $this;
    }

    public function getLibPopulationExposee(): ?string
    {
        return $this->LibPopulationExposee;
    }

    public function setLibPopulationExposee(?string $LibPopulationExposee): static
    {
        $this->LibPopulationExposee = $LibPopulationExposee;

        return $this;
    }

    public function getCommentPopulationExposee(): ?string
    {
        return $this->CommentPopulationExposee;
    }

    public function setCommentPopulationExposee(?string $CommentPopulationExposee): static
    {
        $this->CommentPopulationExposee = $CommentPopulationExposee;

        return $this;
    }

    public function getLibDasBnpv(): ?string
    {
        return $this->LibDasBnpv;
    }

    public function setLibDasBnpv(?string $LibDasBnpv): static
    {
        $this->LibDasBnpv = $LibDasBnpv;

        return $this;
    }

    public function getCommentDasBnpv(): ?string
    {
        return $this->CommentDasBnpv;
    }

    public function setCommentDasBnpv(?string $CommentDasBnpv): static
    {
        $this->CommentDasBnpv = $CommentDasBnpv;

        return $this;
    }

    public function getLibErmr(): ?string
    {
        return $this->LibErmr;
    }

    public function setLibErmr(?string $LibErmr): static
    {
        $this->LibErmr = $LibErmr;

        return $this;
    }

    public function getCommentErmr(): ?string
    {
        return $this->CommentErmr;
    }

    public function setCommentErmr(?string $CommentErmr): static
    {
        $this->CommentErmr = $CommentErmr;

        return $this;
    }

    public function getLibAutreCas(): ?string
    {
        return $this->LibAutreCas;
    }

    public function setLibAutreCas(?string $LibAutreCas): static
    {
        $this->LibAutreCas = $LibAutreCas;

        return $this;
    }

    public function getCommentAutreCas(): ?string
    {
        return $this->CommentAutreCas;
    }

    public function setCommentAutreCas(?string $CommentAutreCas): static
    {
        $this->CommentAutreCas = $CommentAutreCas;

        return $this;
    }

    public function getLibSigEu(): ?string
    {
        return $this->LibSigEu;
    }

    public function setLibSigEu(?string $LibSigEu): static
    {
        $this->LibSigEu = $LibSigEu;

        return $this;
    }

    public function getCommentSigEu(): ?string
    {
        return $this->CommentSigEu;
    }

    public function setCommentSigEu(?string $CommentSigEu): static
    {
        $this->CommentSigEu = $CommentSigEu;

        return $this;
    }

    public function getCommentGeneral(): ?string
    {
        return $this->CommentGeneral;
    }

    public function setCommentGeneral(?string $CommentGeneral): static
    {
        $this->CommentGeneral = $CommentGeneral;

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

    public function getDateCalcul(): ?\DateTimeImmutable
    {
        return $this->DateCalcul;
    }

    public function setDateCalcul(?\DateTimeImmutable $DateCalcul): static
    {
        $this->DateCalcul = $DateCalcul;

        return $this;
    }

    public function getCritereGraviteScore(): ?int
    {
        return $this->CritereGravite_Score;
    }

    public function setCritereGraviteScore(?int $CritereGravite_Score): static
    {
        $this->CritereGravite_Score = $CritereGravite_Score;

        return $this;
    }

    public function getCritereGravitePoids(): ?int
    {
        return $this->CritereGravite_Poids;
    }

    public function setCritereGravitePoids(?int $CritereGravite_Poids): static
    {
        $this->CritereGravite_Poids = $CritereGravite_Poids;

        return $this;
    }

    public function getCarInhabituelScore(): ?int
    {
        return $this->CarInhabituel_Score;
    }

    public function setCarInhabituelScore(?int $CarInhabituel_Score): static
    {
        $this->CarInhabituel_Score = $CarInhabituel_Score;

        return $this;
    }

    public function getCarInhabituelPoids(): ?int
    {
        return $this->CarInhabituel_Poids;
    }

    public function setCarInhabituelPoids(?int $CarInhabituel_Poids): static
    {
        $this->CarInhabituel_Poids = $CarInhabituel_Poids;

        return $this;
    }

    public function getTypePopulationScore(): ?int
    {
        return $this->TypePopulation_Score;
    }

    public function setTypePopulationScore(?int $TypePopulation_Score): static
    {
        $this->TypePopulation_Score = $TypePopulation_Score;

        return $this;
    }

    public function getTypePopulationPoids(): ?int
    {
        return $this->TypePopulation_Poids;
    }

    public function setTypePopulationPoids(?int $TypePopulation_Poids): static
    {
        $this->TypePopulation_Poids = $TypePopulation_Poids;

        return $this;
    }

    public function getSuiteJudScore(): ?int
    {
        return $this->SuiteJud_Score;
    }

    public function setSuiteJudScore(?int $SuiteJud_Score): static
    {
        $this->SuiteJud_Score = $SuiteJud_Score;

        return $this;
    }

    public function getSuiteJudPoids(): ?int
    {
        return $this->SuiteJud_Poids;
    }

    public function setSuiteJudPoids(?int $SuiteJud_Poids): static
    {
        $this->SuiteJud_Poids = $SuiteJud_Poids;

        return $this;
    }

    public function getMediatisationScore(): ?int
    {
        return $this->Mediatisation_Score;
    }

    public function setMediatisationScore(?int $Mediatisation_Score): static
    {
        $this->Mediatisation_Score = $Mediatisation_Score;

        return $this;
    }

    public function getMediatisationPoids(): ?int
    {
        return $this->Mediatisation_Poids;
    }

    public function setMediatisationPoids(?int $Mediatisation_Poids): static
    {
        $this->Mediatisation_Poids = $Mediatisation_Poids;

        return $this;
    }

    public function getProbSensTutelleScore(): ?int
    {
        return $this->ProbSensTutelle_Score;
    }

    public function setProbSensTutelleScore(?int $ProbSensTutelle_Score): static
    {
        $this->ProbSensTutelle_Score = $ProbSensTutelle_Score;

        return $this;
    }

    public function getProbSensTutellePoids(): ?int
    {
        return $this->ProbSensTutelle_Poids;
    }

    public function setProbSensTutellePoids(?int $ProbSensTutelle_Poids): static
    {
        $this->ProbSensTutelle_Poids = $ProbSensTutelle_Poids;

        return $this;
    }

    public function getProbSensPartenairesScore(): ?int
    {
        return $this->ProbSensPartenaires_Score;
    }

    public function setProbSensPartenairesScore(?int $ProbSensPartenaires_Score): static
    {
        $this->ProbSensPartenaires_Score = $ProbSensPartenaires_Score;

        return $this;
    }

    public function getProbSensPartenairesPoids(): ?int
    {
        return $this->ProbSensPartenaires_Poids;
    }

    public function setProbSensPartenairesPoids(?int $ProbSensPartenaires_Poids): static
    {
        $this->ProbSensPartenaires_Poids = $ProbSensPartenaires_Poids;

        return $this;
    }

    public function getProduitSurveillanceScore(): ?int
    {
        return $this->ProduitSurveillance_Score;
    }

    public function setProduitSurveillanceScore(?int $ProduitSurveillance_Score): static
    {
        $this->ProduitSurveillance_Score = $ProduitSurveillance_Score;

        return $this;
    }

    public function getProduitSurveillancePoids(): ?int
    {
        return $this->ProduitSurveillance_Poids;
    }

    public function setProduitSurveillancePoids(?int $ProduitSurveillance_Poids): static
    {
        $this->ProduitSurveillance_Poids = $ProduitSurveillance_Poids;

        return $this;
    }

    public function getPopulationExposeeScore(): ?int
    {
        return $this->PopulationExposee_Score;
    }

    public function setPopulationExposeeScore(?int $PopulationExposee_Score): static
    {
        $this->PopulationExposee_Score = $PopulationExposee_Score;

        return $this;
    }

    public function getPopulationExposeePoids(): ?int
    {
        return $this->PopulationExposee_Poids;
    }

    public function setPopulationExposeePoids(?int $PopulationExposee_Poids): static
    {
        $this->PopulationExposee_Poids = $PopulationExposee_Poids;

        return $this;
    }

    public function getDASBNPVERMRScore(): ?int
    {
        return $this->DASBNPV_eRMR_Score;
    }

    public function setDASBNPVERMRScore(?int $DASBNPV_eRMR_Score): static
    {
        $this->DASBNPV_eRMR_Score = $DASBNPV_eRMR_Score;

        return $this;
    }

    public function getDASBNPVERMRPoids(): ?int
    {
        return $this->DASBNPV_eRMR_Poids;
    }

    public function setDASBNPVERMRPoids(?int $DASBNPV_eRMR_Poids): static
    {
        $this->DASBNPV_eRMR_Poids = $DASBNPV_eRMR_Poids;

        return $this;
    }

    public function getCMSigEUScore(): ?int
    {
        return $this->CM_SigEU_Score;
    }

    public function setCMSigEUScore(?int $CM_SigEU_Score): static
    {
        $this->CM_SigEU_Score = $CM_SigEU_Score;

        return $this;
    }

    public function getCMSigEUPoids(): ?int
    {
        return $this->CM_SigEU_Poids;
    }

    public function setCMSigEUPoids(?int $CM_SigEU_Poids): static
    {
        $this->CM_SigEU_Poids = $CM_SigEU_Poids;

        return $this;
    }

    public function getScoreHR(): ?int
    {
        return $this->ScoreHR;
    }

    public function setScoreHR(?int $ScoreHR): static
    {
        $this->ScoreHR = $ScoreHR;

        return $this;
    }

    public function getNiveauRisqueCalcule(): ?string
    {
        return $this->niveauRisqueCalcule;
    }

    public function setNiveauRisqueCalcule(?string $niveauRisqueCalcule): static
    {
        $this->niveauRisqueCalcule = $niveauRisqueCalcule;

        return $this;
    }

    public function getOccurenceEMScore(): ?int
    {
        return $this->OccurenceEM_Score;
    }

    public function setOccurenceEMScore(?int $OccurenceEM_Score): static
    {
        $this->OccurenceEM_Score = $OccurenceEM_Score;

        return $this;
    }

    public function getOccurenceEMPoids(): ?int
    {
        return $this->OccurenceEM_Poids;
    }

    public function setOccurenceEMPoids(?int $OccurenceEM_Poids): static
    {
        $this->OccurenceEM_Poids = $OccurenceEM_Poids;

        return $this;
    }

    public function getCommentaireDMM(): ?string
    {
        return $this->CommentaireDMM;
    }

    public function setCommentaireDMM(?string $CommentaireDMM): static
    {
        $this->CommentaireDMM = $CommentaireDMM;

        return $this;
    }

    public function getProduits(): ?Produits
    {
        return $this->Produits;
    }

    public function setProduits(?Produits $Produits): static
    {
        $this->Produits = $Produits;

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
