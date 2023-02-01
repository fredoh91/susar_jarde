<?php

namespace App\Entity;

use App\Repository\GlossaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GlossaireRepository::class)]
class Glossaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $itemGlossaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $evaluateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DP = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DMM = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pole_court = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pole_long = null;

    #[ORM\Column(options: ["default" => true])]
    private ?bool $Actif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemGlossaire(): ?string
    {
        return $this->itemGlossaire;
    }

    public function setItemGlossaire(string $itemGlossaire): self
    {
        $this->itemGlossaire = $itemGlossaire;

        return $this;
    }

    public function getEvaluateur(): ?string
    {
        return $this->evaluateur;
    }

    public function setEvaluateur(?string $evaluateur): self
    {
        $this->evaluateur = $evaluateur;

        return $this;
    }

    public function getDP(): ?string
    {
        return $this->DP;
    }

    public function setDP(?string $DP): self
    {
        $this->DP = $DP;

        return $this;
    }

    public function getDMM(): ?string
    {
        return $this->DMM;
    }

    public function setDMM(?string $DMM): self
    {
        $this->DMM = $DMM;

        return $this;
    }

    public function getPoleCourt(): ?string
    {
        return $this->pole_court;
    }

    public function setPoleCourt(?string $pole_court): self
    {
        $this->pole_court = $pole_court;

        return $this;
    }

    public function getPoleLong(): ?string
    {
        return $this->pole_long;
    }

    public function setPoleLong(?string $pole_long): self
    {
        $this->pole_long = $pole_long;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->Actif;
    }

    public function setActif(bool $Actif): self
    {
        $this->Actif = $Actif;

        return $this;
    }
}
