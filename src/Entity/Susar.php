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
}
