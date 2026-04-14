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
}
