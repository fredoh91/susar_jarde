<?php

namespace App\Entity;

use App\Repository\IntervenantsANSMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IntervenantsANSMRepository::class)]
class IntervenantsANSM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DMM_pole = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DMM_pole_court = null;

    #[ORM\Column]
    private ?bool $inactif = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $OrdreTri = null;

    #[ORM\OneToMany(mappedBy: 'IntervenantANSM', targetEntity: Susar::class)]
    private Collection $susars;

    public function __construct()
    {
        $this->susars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDMMPole(): ?string
    {
        return $this->DMM_pole;
    }

    public function setDMMPole(string $DMM_pole): self
    {
        $this->DMM_pole = $DMM_pole;

        return $this;
    }

    public function getDMMPoleCourt(): ?string
    {
        return $this->DMM_pole_court;
    }

    public function setDMMPoleCourt(string $DMM_pole_court): self
    {
        $this->DMM_pole_court = $DMM_pole_court;

        return $this;
    }

    public function isInactif(): ?bool
    {
        return $this->inactif;
    }

    public function setInactif(bool $inactif): self
    {
        $this->inactif = $inactif;

        return $this;
    }

    public function getOrdreTri(): ?int
    {
        return $this->OrdreTri;
    }

    public function setOrdreTri(int $OrdreTri): self
    {
        $this->OrdreTri = $OrdreTri;

        return $this;
    }

    /**
     * @return Collection<int, Susar>
     */
    public function getSusars(): Collection
    {
        return $this->susars;
    }

    public function addSusar(Susar $susar): self
    {
        if (!$this->susars->contains($susar)) {
            $this->susars->add($susar);
            $susar->setIntervenantANSM($this);
        }

        return $this;
    }

    public function removeSusar(Susar $susar): self
    {
        if ($this->susars->removeElement($susar)) {
            // set the owning side to null (unless already changed)
            if ($susar->getIntervenantANSM() === $this) {
                $susar->setIntervenantANSM(null);
            }
        }

        return $this;
    }

    // public function __toString(){
    //     return $this->IntervenantsANSM ; // Remplacer champ par une propriété "string" de l'entité
    // }


}
