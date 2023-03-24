<?php

namespace App\Entity;

use App\Repository\MedicalHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicalHistoryRepository::class)]
class MedicalHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $disease_lib_LLT = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $disease_lib_PT = null;

    #[ORM\Column(nullable: true)]
    private ?int $disease_code_LLT = null;

    #[ORM\Column(nullable: true)]
    private ?int $disease_code_PT = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $continuing = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $medicalcomment = null;

    #[ORM\ManyToOne(inversedBy: 'medicalHistories')]
    private ?Susar $susar = null;

    #[ORM\Column(nullable: true)]
    private ?int $master_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiseaseLibLLT(): ?string
    {
        return $this->disease_lib_LLT;
    }

    public function setDiseaseLibLLT(?string $disease_lib_LLT): self
    {
        $this->disease_lib_LLT = $disease_lib_LLT;

        return $this;
    }

    public function getDiseaseLibPT(): ?string
    {
        return $this->disease_lib_PT;
    }

    public function setDiseaseLibPT(?string $disease_lib_PT): self
    {
        $this->disease_lib_PT = $disease_lib_PT;

        return $this;
    }

    public function getDiseaseCodeLLT(): ?int
    {
        return $this->disease_code_LLT;
    }

    public function setDiseaseCodeLLT(?int $disease_code_LLT): self
    {
        $this->disease_code_LLT = $disease_code_LLT;

        return $this;
    }

    public function getDiseaseCodePT(): ?int
    {
        return $this->disease_code_PT;
    }

    public function setDiseaseCodePT(?int $disease_code_PT): self
    {
        $this->disease_code_PT = $disease_code_PT;

        return $this;
    }

    public function getContinuing(): ?string
    {
        return $this->continuing;
    }

    public function setContinuing(?string $continuing): self
    {
        $this->continuing = $continuing;

        return $this;
    }

    public function getMedicalcomment(): ?string
    {
        return $this->medicalcomment;
    }

    public function setMedicalcomment(?string $medicalcomment): self
    {
        $this->medicalcomment = $medicalcomment;

        return $this;
    }

    public function getSusar(): ?Susar
    {
        return $this->susar;
    }

    public function setSusar(?Susar $susar): self
    {
        $this->susar = $susar;

        return $this;
    }

    public function getMasterId(): ?int
    {
        return $this->master_id;
    }

    public function setMasterId(?int $master_id): self
    {
        $this->master_id = $master_id;

        return $this;
    }
}
