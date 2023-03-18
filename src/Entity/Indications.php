<?php

namespace App\Entity;

use App\Repository\IndicationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndicationsRepository::class)]
class Indications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productIndications = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productIndications_eng = null;

    #[ORM\Column(nullable: true)]
    private ?int $codeProductIndications = null;

    #[ORM\ManyToOne(inversedBy: 'IndicationsTable')]
    private ?Susar $susar = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productcharacterization = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductIndications(): ?string
    {
        return $this->productIndications;
    }

    public function setProductIndications(?string $productIndications): self
    {
        $this->productIndications = $productIndications;

        return $this;
    }

    public function getProductIndicationsEng(): ?string
    {
        return $this->productIndications_eng;
    }

    public function setProductIndicationsEng(?string $productIndications_eng): self
    {
        $this->productIndications_eng = $productIndications_eng;

        return $this;
    }

    public function getCodeProductIndications(): ?int
    {
        return $this->codeProductIndications;
    }

    public function setCodeProductIndications(?int $codeProductIndications): self
    {
        $this->codeProductIndications = $codeProductIndications;

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

    public function getProductcharacterization(): ?string
    {
        return $this->productcharacterization;
    }

    public function setProductcharacterization(?string $productcharacterization): self
    {
        $this->productcharacterization = $productcharacterization;

        return $this;
    }
}
