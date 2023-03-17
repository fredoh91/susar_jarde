<?php

namespace App\Entity;

use App\Repository\IndicationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndicationRepository::class)]
class Indication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productIndication = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productIndication_eng = null;

    #[ORM\Column(nullable: true)]
    private ?int $codeProductIndication = null;

    #[ORM\ManyToOne(inversedBy: 'IndicationTable')]
    private ?Susar $susar = null;

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

    public function getProductIndication(): ?string
    {
        return $this->productIndication;
    }

    public function setProductIndication(?string $productIndication): self
    {
        $this->productIndication = $productIndication;

        return $this;
    }

    public function getProductIndicationEng(): ?string
    {
        return $this->productIndication_eng;
    }

    public function setProductIndicationEng(?string $productIndication_eng): self
    {
        $this->productIndication_eng = $productIndication_eng;

        return $this;
    }

    public function getCodeProductIndication(): ?int
    {
        return $this->codeProductIndication;
    }

    public function setCodeProductIndication(?int $codeProductIndication): self
    {
        $this->codeProductIndication = $codeProductIndication;

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
}
