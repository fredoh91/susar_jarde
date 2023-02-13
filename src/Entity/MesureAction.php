<?php

namespace App\Entity;

use App\Repository\MesureActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MesureActionRepository::class)]
class MesureAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Libelle = null;

    #[ORM\Column]
    private ?bool $inactif = null;

    #[ORM\OneToMany(mappedBy: 'MesureAction', targetEntity: Susar::class)]
    private Collection $susars;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $OrdreTri = null;

    public function __construct()
    {
        $this->susars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

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
            $susar->setMesureAction($this);
        }

        return $this;
    }

    public function removeSusar(Susar $susar): self
    {
        if ($this->susars->removeElement($susar)) {
            // set the owning side to null (unless already changed)
            if ($susar->getMesureAction() === $this) {
                $susar->setMesureAction(null);
            }
        }

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
}
