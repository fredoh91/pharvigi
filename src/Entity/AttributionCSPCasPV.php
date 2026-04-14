<?php

namespace App\Entity;

use App\Repository\AttributionCSPCasPVRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributionCSPCasPVRepository::class)]
class AttributionCSPCasPV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserModif = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'attributionCSPs')]
    private ?ListeCSP $ListeCSP = null;

    #[ORM\ManyToOne(inversedBy: 'attributionCSPs')]
    private ?CasPV $CasPV = null;

    /**
     * @var Collection<int, AttributionExperts>
     */
    #[ORM\OneToMany(targetEntity: AttributionExperts::class, mappedBy: 'AttributionCSPCasPV')]
    private Collection $attributionExperts;

    public function __construct()
    {
        $this->attributionExperts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getListeCSP(): ?ListeCSP
    {
        return $this->ListeCSP;
    }

    public function setListeCSP(?ListeCSP $ListeCSP): static
    {
        $this->ListeCSP = $ListeCSP;

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
            $attributionExpert->setAttributionCSPCasPV($this);
        }

        return $this;
    }

    public function removeAttributionExpert(AttributionExperts $attributionExpert): static
    {
        if ($this->attributionExperts->removeElement($attributionExpert)) {
            // set the owning side to null (unless already changed)
            if ($attributionExpert->getAttributionCSPCasPV() === $this) {
                $attributionExpert->setAttributionCSPCasPV(null);
            }
        }

        return $this;
    }
}
