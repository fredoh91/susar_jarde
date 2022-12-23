<?php

namespace App\Entity;

use App\Repository\SusarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SusarRepository::class)]
class Susar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $master_id = null;

    #[ORM\Column]
    private ?int $caseid = null;

    #[ORM\Column(length: 16)]
    private ?string $specificcaseid = null;

    #[ORM\Column]
    private ?int $DLPVersion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $creationdate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $statusdate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $studytitle = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $sponsorstudynumb = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $num_eudract = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays_etude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TypeSusar = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $indication = null;

    #[ORM\ManyToOne(inversedBy: 'susars')]
    private ?IntervenantsANSM $intervenantANSM = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMasterId(): ?int
    {
        return $this->master_id;
    }

    public function setMasterId(int $master_id): self
    {
        $this->master_id = $master_id;

        return $this;
    }

    public function getCaseid(): ?int
    {
        return $this->caseid;
    }

    public function setCaseid(int $caseid): self
    {
        $this->caseid = $caseid;

        return $this;
    }

    public function getSpecificcaseid(): ?string
    {
        return $this->specificcaseid;
    }

    public function setSpecificcaseid(string $specificcaseid): self
    {
        $this->specificcaseid = $specificcaseid;

        return $this;
    }

    public function getDLPVersion(): ?int
    {
        return $this->DLPVersion;
    }

    public function setDLPVersion(int $DLPVersion): self
    {
        $this->DLPVersion = $DLPVersion;

        return $this;
    }

    public function getCreationdate(): ?\DateTimeInterface
    {
        return $this->creationdate;
    }

    public function setCreationdate(?\DateTimeInterface $creationdate): self
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    public function getStatusdate(): ?\DateTimeInterface
    {
        return $this->statusdate;
    }

    public function setStatusdate(?\DateTimeInterface $statusdate): self
    {
        $this->statusdate = $statusdate;

        return $this;
    }

    public function getStudytitle(): ?string
    {
        return $this->studytitle;
    }

    public function setStudytitle(?string $studytitle): self
    {
        $this->studytitle = $studytitle;

        return $this;
    }

    public function getSponsorstudynumb(): ?string
    {
        return $this->sponsorstudynumb;
    }

    public function setSponsorstudynumb(?string $sponsorstudynumb): self
    {
        $this->sponsorstudynumb = $sponsorstudynumb;

        return $this;
    }

    public function getNumEudract(): ?string
    {
        return $this->num_eudract;
    }

    public function setNumEudract(?string $num_eudract): self
    {
        $this->num_eudract = $num_eudract;

        return $this;
    }

    public function getPaysEtude(): ?string
    {
        return $this->pays_etude;
    }

    public function setPaysEtude(?string $pays_etude): self
    {
        $this->pays_etude = $pays_etude;

        return $this;
    }

    public function getTypeSusar(): ?string
    {
        return $this->TypeSusar;
    }

    public function setTypeSusar(?string $TypeSusar): self
    {
        $this->TypeSusar = $TypeSusar;

        return $this;
    }

    public function getIndication(): ?string
    {
        return $this->indication;
    }

    public function setIndication(?string $indication): self
    {
        $this->indication = $indication;

        return $this;
    }

    public function getIntervenantANSM(): ?intervenantsANSM
    {
        return $this->intervenantANSM;
    }

    public function setIntervenantANSM(?intervenantsANSM $intervenantANSM): self
    {
        $this->intervenantANSM = $intervenantANSM;

        return $this;
    }

    // public function __toString(){
    //     return $this->IntervenantsANSM; // Remplacer champ par une propriété "string" de l'entité
    // }

}
