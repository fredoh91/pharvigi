<?php

namespace App\Entity;

use App\Repository\CasPVRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CasPVRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'cm' => \App\Entity\CM\CM::class,
    'emm' => \App\Entity\CM\EMM::class,
    'simad' => \App\Entity\SIMAD\SIMAD::class,
    ])]
abstract class CasPV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $TypeCasPV = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $numeroBNPV = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $problematique = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $propositionCRPV = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $conclusions = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $presentation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $CRPV = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $codeCRPV = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gravite = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $deces = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $miseEnJeuPronostic = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $hospitalisation = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $incapacite = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $anomalieCongenitale = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $autreSituation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $typologie = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateArrivee = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $uniteAge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $effetIndesirable = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $prequalificationDSURV = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motifPrequalification = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $investigationDP = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $echangeDMM_CRPV = null;

    #[ORM\Column(nullable: true)]
    private ?bool $cluster = null;

    #[ORM\Column(nullable: true)]
    private ?bool $finalise = null;

    #[ORM\Column(nullable: true)]
    private ?bool $casPere = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $lettre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motifQualificationDMM = null;

    #[ORM\Column(nullable: true)]
    private ?bool $SRE = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserModif = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveauRisqueFinal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveauRisquePGS = null;

    /**
     * @var Collection<int, AttributionCSPCasPV>
     */
    #[ORM\OneToMany(targetEntity: AttributionCSPCasPV::class, mappedBy: 'CasPV')]
    private Collection $attributionCSPs;

    /**
     * @var Collection<int, StatutCasPV>
     */
    #[ORM\OneToMany(targetEntity: StatutCasPV::class, mappedBy: 'statutCasPV')]
    private Collection $statutCasPVs;

    public function __construct()
    {
        $this->attributionCSPs = new ArrayCollection();
        $this->statutCasPVs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCasPV(): ?string
    {
        return $this->TypeCasPV;
    }

    public function setTypeCasPV(?string $TypeCasPV): static
    {
        $this->TypeCasPV = $TypeCasPV;

        return $this;
    }

    public function getNumeroBNPV(): ?string
    {
        return $this->numeroBNPV;
    }

    public function setNumeroBNPV(?string $numeroBNPV): static
    {
        $this->numeroBNPV = $numeroBNPV;

        return $this;
    }

    public function getProblematique(): ?string
    {
        return $this->problematique;
    }

    public function setProblematique(?string $problematique): static
    {
        $this->problematique = $problematique;

        return $this;
    }

    public function getPropositionCRPV(): ?string
    {
        return $this->propositionCRPV;
    }

    public function setPropositionCRPV(?string $propositionCRPV): static
    {
        $this->propositionCRPV = $propositionCRPV;

        return $this;
    }

    public function getConclusions(): ?string
    {
        return $this->conclusions;
    }

    public function setConclusions(?string $conclusions): static
    {
        $this->conclusions = $conclusions;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getCRPV(): ?string
    {
        return $this->CRPV;
    }

    public function setCRPV(?string $CRPV): static
    {
        $this->CRPV = $CRPV;

        return $this;
    }

    public function getCodeCRPV(): ?string
    {
        return $this->codeCRPV;
    }

    public function setCodeCRPV(?string $codeCRPV): static
    {
        $this->codeCRPV = $codeCRPV;

        return $this;
    }

    public function getGravite(): ?string
    {
        return $this->gravite;
    }

    public function setGravite(?string $gravite): static
    {
        $this->gravite = $gravite;

        return $this;
    }

    public function getDeces(): ?string
    {
        return $this->deces;
    }

    public function setDeces(?string $deces): static
    {
        $this->deces = $deces;

        return $this;
    }

    public function getMiseEnJeuPronostic(): ?string
    {
        return $this->miseEnJeuPronostic;
    }

    public function setMiseEnJeuPronostic(?string $miseEnJeuPronostic): static
    {
        $this->miseEnJeuPronostic = $miseEnJeuPronostic;

        return $this;
    }

    public function getHospitalisation(): ?string
    {
        return $this->hospitalisation;
    }

    public function setHospitalisation(?string $hospitalisation): static
    {
        $this->hospitalisation = $hospitalisation;

        return $this;
    }

    public function getIncapacite(): ?string
    {
        return $this->incapacite;
    }

    public function setIncapacite(?string $incapacite): static
    {
        $this->incapacite = $incapacite;

        return $this;
    }

    public function getAnomalieCongenitale(): ?string
    {
        return $this->anomalieCongenitale;
    }

    public function setAnomalieCongenitale(?string $anomalieCongenitale): static
    {
        $this->anomalieCongenitale = $anomalieCongenitale;

        return $this;
    }

    public function getAutreSituation(): ?string
    {
        return $this->autreSituation;
    }

    public function setAutreSituation(?string $autreSituation): static
    {
        $this->autreSituation = $autreSituation;

        return $this;
    }

    public function getTypologie(): ?string
    {
        return $this->typologie;
    }

    public function setTypologie(?string $typologie): static
    {
        $this->typologie = $typologie;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeImmutable
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(?\DateTimeImmutable $dateArrivee): static
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getUniteAge(): ?string
    {
        return $this->uniteAge;
    }

    public function setUniteAge(?string $uniteAge): static
    {
        $this->uniteAge = $uniteAge;

        return $this;
    }

    public function getEffetIndesirable(): ?string
    {
        return $this->effetIndesirable;
    }

    public function setEffetIndesirable(?string $effetIndesirable): static
    {
        $this->effetIndesirable = $effetIndesirable;

        return $this;
    }

    public function getPrequalificationDSURV(): ?string
    {
        return $this->prequalificationDSURV;
    }

    public function setPrequalificationDSURV(?string $prequalificationDSURV): static
    {
        $this->prequalificationDSURV = $prequalificationDSURV;

        return $this;
    }

    public function getMotifPrequalification(): ?string
    {
        return $this->motifPrequalification;
    }

    public function setMotifPrequalification(?string $motifPrequalification): static
    {
        $this->motifPrequalification = $motifPrequalification;

        return $this;
    }

    public function getInvestigationDP(): ?string
    {
        return $this->investigationDP;
    }

    public function setInvestigationDP(?string $investigationDP): static
    {
        $this->investigationDP = $investigationDP;

        return $this;
    }

    public function getEchangeDMMCRPV(): ?string
    {
        return $this->echangeDMM_CRPV;
    }

    public function setEchangeDMMCRPV(?string $echangeDMM_CRPV): static
    {
        $this->echangeDMM_CRPV = $echangeDMM_CRPV;

        return $this;
    }

    public function isCluster(): ?bool
    {
        return $this->cluster;
    }

    public function setCluster(?bool $cluster): static
    {
        $this->cluster = $cluster;

        return $this;
    }

    public function isFinalise(): ?bool
    {
        return $this->finalise;
    }

    public function setFinalise(?bool $finalise): static
    {
        $this->finalise = $finalise;

        return $this;
    }

    public function isCasPere(): ?bool
    {
        return $this->casPere;
    }

    public function setCasPere(?bool $casPere): static
    {
        $this->casPere = $casPere;

        return $this;
    }

    public function getLettre(): ?string
    {
        return $this->lettre;
    }

    public function setLettre(?string $lettre): static
    {
        $this->lettre = $lettre;

        return $this;
    }

    public function getMotifQualificationDMM(): ?string
    {
        return $this->motifQualificationDMM;
    }

    public function setMotifQualificationDMM(?string $motifQualificationDMM): static
    {
        $this->motifQualificationDMM = $motifQualificationDMM;

        return $this;
    }

    public function isSRE(): ?bool
    {
        return $this->SRE;
    }

    public function setSRE(?bool $SRE): static
    {
        $this->SRE = $SRE;

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

    public function getNiveauRisqueFinal(): ?string
    {
        return $this->niveauRisqueFinal;
    }

    public function setNiveauRisqueFinal(?string $niveauRisqueFinal): static
    {
        $this->niveauRisqueFinal = $niveauRisqueFinal;

        return $this;
    }

    public function getNiveauRisquePGS(): ?string
    {
        return $this->niveauRisquePGS;
    }

    public function setNiveauRisquePGS(?string $niveauRisquePGS): static
    {
        $this->niveauRisquePGS = $niveauRisquePGS;

        return $this;
    }

    /**
     * @return Collection<int, AttributionCSPCasPV>
     */
    public function getAttributionCSPs(): Collection
    {
        return $this->attributionCSPs;
    }

    public function addAttributionCSP(AttributionCSPCasPV $attributionCSP): static
    {
        if (!$this->attributionCSPs->contains($attributionCSP)) {
            $this->attributionCSPs->add($attributionCSP);
            $attributionCSP->setCasPV($this);
        }

        return $this;
    }

    public function removeAttributionCSP(AttributionCSPCasPV $attributionCSP): static
    {
        if ($this->attributionCSPs->removeElement($attributionCSP)) {
            // set the owning side to null (unless already changed)
            if ($attributionCSP->getCasPV() === $this) {
                $attributionCSP->setCasPV(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StatutCasPV>
     */
    public function getStatutCasPVs(): Collection
    {
        return $this->statutCasPVs;
    }

    public function addStatutCasPV(StatutCasPV $statutCasPV): static
    {
        if (!$this->statutCasPVs->contains($statutCasPV)) {
            $this->statutCasPVs->add($statutCasPV);
            $statutCasPV->setStatutCasPV($this);
        }

        return $this;
    }

    public function removeStatutCasPV(StatutCasPV $statutCasPV): static
    {
        if ($this->statutCasPVs->removeElement($statutCasPV)) {
            // set the owning side to null (unless already changed)
            if ($statutCasPV->getStatutCasPV() === $this) {
                $statutCasPV->setStatutCasPV(null);
            }
        }

        return $this;
    }
}
