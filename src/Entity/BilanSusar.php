<?php

namespace App\Entity;

use App\Repository\BilanSusarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BilanSusarRepository::class)]
class BilanSusar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $creationdate = null;

    #[ORM\Column(nullable: true)]
    private ?int $NbTotal = null;

    #[ORM\Column(nullable: true)]
    private ?int $NbNonAiguille = null;

    #[ORM\Column(nullable: true)]
    private ?int $NbAiguille = null;

    #[ORM\Column(nullable: true)]
    private ?int $NbNonEvalue = null;

    #[ORM\Column(nullable: true)]
    private ?int $NbEvalue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateImport = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $statusdate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ListeDateImport = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNbTotal(): ?int
    {
        return $this->NbTotal;
    }

    public function setNbTotal(?int $NbTotal): self
    {
        $this->NbTotal = $NbTotal;

        return $this;
    }

    public function getNbNonAiguille(): ?int
    {
        return $this->NbNonAiguille;
    }

    public function setNbNonAiguille(?int $NbNonAiguille): self
    {
        $this->NbNonAiguille = $NbNonAiguille;

        return $this;
    }

    public function getNbAiguille(): ?int
    {
        return $this->NbAiguille;
    }

    public function setNbAiguille(?int $NbAiguille): self
    {
        $this->NbAiguille = $NbAiguille;

        return $this;
    }

    public function getNbNonEvalue(): ?int
    {
        return $this->NbNonEvalue;
    }

    public function setNbNonEvalue(?int $NbNonEvalue): self
    {
        $this->NbNonEvalue = $NbNonEvalue;

        return $this;
    }

    public function getNbEvalue(): ?int
    {
        return $this->NbEvalue;
    }

    public function setNbEvalue(?int $NbEvalue): self
    {
        $this->NbEvalue = $NbEvalue;

        return $this;
    }

    public function getDateImport(): ?\DateTimeInterface
    {
        return $this->dateImport;
    }

    public function setDateImport(?\DateTimeInterface $DateImport): self
    {
        $this->dateImport = $DateImport;

        return $this;
    }

    public function getStatusdate(): ?\DateTimeInterface
    {
        return $this->statusdate;
    }

    public function setStatusdate(?\DateTimeInterface $statusdate): static
    {
        $this->statusdate = $statusdate;

        return $this;
    }

    public function getListeDateImport(): ?string
    {
        return $this->ListeDateImport;
    }

    public function setListeDateImport(?string $ListeDateImport): static
    {
        $this->ListeDateImport = $ListeDateImport;

        return $this;
    }
}
