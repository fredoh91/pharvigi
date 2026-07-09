<?php

namespace App\Entity;

use App\Repository\ListeCSPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeCSPRepository::class)]
class ListeCSP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateCSP = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TypeCSP = null;

    #[ORM\Column(nullable: true)]
    private ?bool $FlInactive = null;

    /**
     * @var Collection<int, AttributionCSPCasPV>
     */
    #[ORM\OneToMany(targetEntity: AttributionCSPCasPV::class, mappedBy: 'ListeCSP')]
    private Collection $attributionCSPs;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateMaxArriveeMailCRPV_CEIP = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateMaxPrequalifSURV = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateMaxQualifDMM = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateMaxSecurisationSURV = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateEnvoiExperts = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateMaxReceptionAvisExperts = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateMaxImportAvisExpert = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateMaxPrepPlanning = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateMaxEnvoiListeCasMembresCSP = null;

    public function __construct()
    {
        $this->attributionCSPs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCSP(): ?\DateTimeImmutable
    {
        return $this->DateCSP;
    }

    public function setDateCSP(?\DateTimeImmutable $DateCSP): static
    {
        $this->DateCSP = $DateCSP;

        return $this;
    }

    public function getTypeCSP(): ?string
    {
        return $this->TypeCSP;
    }

    public function setTypeCSP(?string $TypeCSP): static
    {
        $this->TypeCSP = $TypeCSP;

        return $this;
    }

    public function isFlInactive(): ?bool
    {
        return $this->FlInactive;
    }

    public function setFlInactive(?bool $FlInactive): static
    {
        $this->FlInactive = $FlInactive;

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
            $attributionCSP->setListeCSP($this);
        }

        return $this;
    }

    public function removeAttributionCSP(AttributionCSPCasPV $attributionCSP): static
    {
        if ($this->attributionCSPs->removeElement($attributionCSP)) {
            // set the owning side to null (unless already changed)
            if ($attributionCSP->getListeCSP() === $this) {
                $attributionCSP->setListeCSP(null);
            }
        }

        return $this;
    }

    public function getDateMaxArriveeMailCRPVCEIP(): ?\DateTimeImmutable
    {
        return $this->DateMaxArriveeMailCRPV_CEIP;
    }

    public function setDateMaxArriveeMailCRPVCEIP(?\DateTimeImmutable $DateMaxArriveeMailCRPV_CEIP): static
    {
        $this->DateMaxArriveeMailCRPV_CEIP = $DateMaxArriveeMailCRPV_CEIP;

        return $this;
    }

    public function getDateMaxPrequalifSURV(): ?\DateTimeImmutable
    {
        return $this->DateMaxPrequalifSURV;
    }

    public function setDateMaxPrequalifSURV(?\DateTimeImmutable $DateMaxPrequalifSURV): static
    {
        $this->DateMaxPrequalifSURV = $DateMaxPrequalifSURV;

        return $this;
    }

    public function getDateMaxQualifDMM(): ?\DateTimeImmutable
    {
        return $this->DateMaxQualifDMM;
    }

    public function setDateMaxQualifDMM(?\DateTimeImmutable $DateMaxQualifDMM): static
    {
        $this->DateMaxQualifDMM = $DateMaxQualifDMM;

        return $this;
    }

    public function getDateMaxSecurisationSURV(): ?\DateTimeImmutable
    {
        return $this->DateMaxSecurisationSURV;
    }

    public function setDateMaxSecurisationSURV(?\DateTimeImmutable $DateMaxSecurisationSURV): static
    {
        $this->DateMaxSecurisationSURV = $DateMaxSecurisationSURV;

        return $this;
    }

    public function getDateEnvoiExperts(): ?\DateTimeImmutable
    {
        return $this->DateEnvoiExperts;
    }

    public function setDateEnvoiExperts(?\DateTimeImmutable $DateEnvoiExperts): static
    {
        $this->DateEnvoiExperts = $DateEnvoiExperts;

        return $this;
    }

    public function getDateMaxReceptionAvisExperts(): ?\DateTimeImmutable
    {
        return $this->DateMaxReceptionAvisExperts;
    }

    public function setDateMaxReceptionAvisExperts(?\DateTimeImmutable $DateMaxReceptionAvisExperts): static
    {
        $this->DateMaxReceptionAvisExperts = $DateMaxReceptionAvisExperts;

        return $this;
    }

    public function getDateMaxImportAvisExpert(): ?\DateTimeImmutable
    {
        return $this->DateMaxImportAvisExpert;
    }

    public function setDateMaxImportAvisExpert(?\DateTimeImmutable $DateMaxImportAvisExpert): static
    {
        $this->DateMaxImportAvisExpert = $DateMaxImportAvisExpert;

        return $this;
    }

    public function getDateMaxPrepPlanning(): ?\DateTimeImmutable
    {
        return $this->DateMaxPrepPlanning;
    }

    public function setDateMaxPrepPlanning(?\DateTimeImmutable $DateMaxPrepPlanning): static
    {
        $this->DateMaxPrepPlanning = $DateMaxPrepPlanning;

        return $this;
    }

    public function getDateMaxEnvoiListeCasMembresCSP(): ?\DateTimeImmutable
    {
        return $this->DateMaxEnvoiListeCasMembresCSP;
    }

    public function setDateMaxEnvoiListeCasMembresCSP(?\DateTimeImmutable $DateMaxEnvoiListeCasMembresCSP): static
    {
        $this->DateMaxEnvoiListeCasMembresCSP = $DateMaxEnvoiListeCasMembresCSP;

        return $this;
    }
}
