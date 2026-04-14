<?php

namespace App\Entity;

use App\Repository\ListeExpertsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeExpertsRepository::class)]
class ListeExperts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $NumBinome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Civilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TypeExpert = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateDebutNomination = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateFinNomination = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateDPI = null;

    /**
     * @var Collection<int, AttributionExperts>
     */
    #[ORM\OneToMany(targetEntity: AttributionExperts::class, mappedBy: 'ListeExperts')]
    private Collection $attributionExperts;

    public function __construct()
    {
        $this->attributionExperts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumBinome(): ?int
    {
        return $this->NumBinome;
    }

    public function setNumBinome(?int $NumBinome): static
    {
        $this->NumBinome = $NumBinome;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->Civilite;
    }

    public function setCivilite(?string $Civilite): static
    {
        $this->Civilite = $Civilite;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getTypeExpert(): ?string
    {
        return $this->TypeExpert;
    }

    public function setTypeExpert(?string $TypeExpert): static
    {
        $this->TypeExpert = $TypeExpert;

        return $this;
    }

    public function getDateDebutNomination(): ?\DateTimeImmutable
    {
        return $this->DateDebutNomination;
    }

    public function setDateDebutNomination(?\DateTimeImmutable $DateDebutNomination): static
    {
        $this->DateDebutNomination = $DateDebutNomination;

        return $this;
    }

    public function getDateFinNomination(): ?\DateTimeImmutable
    {
        return $this->DateFinNomination;
    }

    public function setDateFinNomination(?\DateTimeImmutable $DateFinNomination): static
    {
        $this->DateFinNomination = $DateFinNomination;

        return $this;
    }

    public function getDateDPI(): ?\DateTimeImmutable
    {
        return $this->DateDPI;
    }

    public function setDateDPI(?\DateTimeImmutable $DateDPI): static
    {
        $this->DateDPI = $DateDPI;

        return $this;
    }

    /**
     * @return Collection<int, AttributionExperts>
     */
    public function getAttributionExperts(): Collection
    {
        return $this->attributionExperts;
    }

    public function addAttributionExpert(AttributionExperts $attributionExpert): static
    {
        if (!$this->attributionExperts->contains($attributionExpert)) {
            $this->attributionExperts->add($attributionExpert);
            $attributionExpert->setListeExperts($this);
        }

        return $this;
    }

    public function removeAttributionExpert(AttributionExperts $attributionExpert): static
    {
        if ($this->attributionExperts->removeElement($attributionExpert)) {
            // set the owning side to null (unless already changed)
            if ($attributionExpert->getListeExperts() === $this) {
                $attributionExpert->setListeExperts(null);
            }
        }

        return $this;
    }
}
