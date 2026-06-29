<?php

namespace App\Entity;

use App\Repository\DonneesAAnonymiserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonneesAAnonymiserRepository::class)]
class DonneesAAnonymiser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $entite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $champ = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $texteComplet = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $textAAnonymiser = null;

    #[ORM\ManyToOne(inversedBy: 'donneesAAnonymisers')]
    private ?CasPV $CasPV = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $raison = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntite(): ?string
    {
        return $this->entite;
    }

    public function setEntite(?string $entite): static
    {
        $this->entite = $entite;

        return $this;
    }

    public function getChamp(): ?string
    {
        return $this->champ;
    }

    public function setChamp(?string $champ): static
    {
        $this->champ = $champ;

        return $this;
    }

    public function getTexteComplet(): ?string
    {
        return $this->texteComplet;
    }

    public function setTexteComplet(?string $texteComplet): static
    {
        $this->texteComplet = $texteComplet;

        return $this;
    }

    public function getTextAAnonymiser(): ?string
    {
        return $this->textAAnonymiser;
    }

    public function setTextAAnonymiser(?string $textAAnonymiser): static
    {
        $this->textAAnonymiser = $textAAnonymiser;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function setRaison(?string $raison): static
    {
        $this->raison = $raison;

        return $this;
    }
}
