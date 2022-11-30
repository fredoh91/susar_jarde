<?php

namespace App\Entity;

use App\Repository\TermeRechAttribDMMpoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TermeRechAttribDMMpoleRepository::class)]
class TermeRechAttribDMMpole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $DMM = null;

    #[ORM\Column(length: 255)]
    private ?string $pole_long = null;

    #[ORM\Column(length: 255)]
    private ?string $pole_court = null;

    #[ORM\Column(length: 255)]
    private ?string $TermeRech = null;

    #[ORM\Column(options: ["default" => true])]
    private ?bool $Actif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDMM(): ?string
    {
        return $this->DMM;
    }

    public function setDMM(string $DMM): self
    {
        $this->DMM = $DMM;

        return $this;
    }

    public function getPoleLong(): ?string
    {
        return $this->pole_long;
    }

    public function setPoleLong(string $pole_long): self
    {
        $this->pole_long = $pole_long;

        return $this;
    }

    public function getPoleCourt(): ?string
    {
        return $this->pole_court;
    }

    public function setPoleCourt(string $pole_court): self
    {
        $this->pole_court = $pole_court;

        return $this;
    }

    public function getTermeRech(): ?string
    {
        return $this->TermeRech;
    }

    public function setTermeRech(string $TermeRech): self
    {
        $this->TermeRech = $TermeRech;

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
