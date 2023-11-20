<?php

namespace App\Entity;

class SearchListeEvalSusar
{
    private ?int $master_id = null;
    private ?int $caseid = null;
    private ?string $specificcaseid = null;
    private ?int $DLPVersion = null;
    private ?string $num_eudract = null;
    private ?string $worldWide_id = null;
    private ?string $sponsorstudynumb = null;
    private ?string $studytitle = null;
    private ?string $productName = null;
    private ?string $substanceName = null;
    private ?string $indication = null;
    private ?string $indication_eng = null;
    private ?IntervenantsANSM $intervenantANSM = null;
    private ?MesureAction $MesureAction = null;
    private ?\DateTimeInterface $debutDateAiguillage = null;
    private ?\DateTimeInterface $finDateAiguillage = null;
    private ?\DateTimeInterface $debutDateEvaluation = null;
    private ?\DateTimeInterface $finDateEvaluation = null;
    private ?\DateTimeInterface $debutStatusDate = null;
    private ?\DateTimeInterface $finStatusDate = null;
    private ?\DateTimeInterface $debutDateImport = null;
    private ?\DateTimeInterface $finDateImport = null;
    private ?string $evalue = null;
    private ?string $aiguille = null;
 
    public function getMasterId(): ?int
    {
        return $this->master_id;
    }

    public function setMasterId(int $master_id): self
    {
        $this->master_id = $master_id;

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

    public function getNumEudract(): ?string
    {
        return $this->num_eudract;
    }

    public function setNumEudract(?string $num_eudract): self
    {
        $this->num_eudract = $num_eudract;

        return $this;
    }

    public function getWorldWideId(): ?string
    {
        return $this->worldWide_id;
    }

    public function setWorldWideId(?string $worldWide_id): self
    {
        $this->worldWide_id = $worldWide_id;

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

    public function getStudytitle(): ?string
    {
        return $this->studytitle;
    }

    public function setStudytitle(?string $studytitle): self
    {
        $this->studytitle = $studytitle;

        return $this;
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

    public function getSubstanceName(): ?string
    {
        return $this->substanceName;
    }

    public function setSubstanceName(?string $substanceName): self
    {
        $this->substanceName = $substanceName;

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

    public function getIndicationEng(): ?string
    {
        return $this->indication_eng;
    }

    public function setIndicationEng(?string $indication_eng): self
    {
        $this->indication_eng = $indication_eng;

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

    public function getMesureAction(): ?MesureAction
    {
        return $this->MesureAction;
    }

    public function setMesureAction(?MesureAction $MesureAction): self
    {
        $this->MesureAction = $MesureAction;

        return $this;
    }

    /**
     * Get the value of caseid
     */ 
    public function getCaseid()
    {
        return $this->caseid;
    }

    /**
     * Set the value of caseid
     *
     * @return  self
     */ 
    public function setCaseid($caseid)
    {
        $this->caseid = $caseid;

        return $this;
    }

    public function getDebutDateAiguillage(): ?\DateTimeInterface
    {
        return $this->debutDateAiguillage;
    }

    public function setDebutDateAiguillage(?\DateTimeInterface $debutDateAiguillage): self
    {
        $this->debutDateAiguillage = $debutDateAiguillage;

        return $this;
    }
    
    public function getFinDateAiguillage(): ?\DateTimeInterface
    {
        return $this->finDateAiguillage;
    }

    public function setFinDateAiguillage(?\DateTimeInterface $finDateAiguillage): self
    {
        $this->finDateAiguillage = $finDateAiguillage;

        return $this;
    } 

    public function getDebutDateEvaluation(): ?\DateTimeInterface
    {
        return $this->debutDateEvaluation;
    }

    public function setDebutDateEvaluation(?\DateTimeInterface $debutDateEvaluation): self
    {
        $this->debutDateEvaluation = $debutDateEvaluation;

        return $this;
    }
    
    public function getFinDateEvaluation(): ?\DateTimeInterface
    {
        return $this->finDateEvaluation;
    }

    public function setFinDateEvaluation(?\DateTimeInterface $finDateEvaluation): self
    {
        $this->finDateEvaluation = $finDateEvaluation;

        return $this;
    } 

    public function getDebutStatusDate(): ?\DateTimeInterface
    {
        return $this->debutStatusDate;
    }

    public function setDebutStatusDate(?\DateTimeInterface $debutStatusDate): self
    {
        $this->debutStatusDate = $debutStatusDate;

        return $this;
    }
    
    public function getFinStatusDate(): ?\DateTimeInterface
    {
        return $this->finStatusDate;
    }

    public function setFinStatusDate(?\DateTimeInterface $finStatusDate): self
    {
        $this->finStatusDate = $finStatusDate;

        return $this;
    }
    

    public function getDebutDateImport(): ?\DateTimeInterface
    {
        return $this->debutDateImport;
    }

    public function setDebutDateImport(?\DateTimeInterface $debutDateImport): self
    {
        $this->debutDateImport = $debutDateImport;

        return $this;
    }
    
    public function getFinDateImport(): ?\DateTimeInterface
    {
        return $this->finDateImport;
    }

    public function setFinDateImport(?\DateTimeInterface $finDateImport): self
    {
        $this->finDateImport = $finDateImport;

        return $this;
    }
    
    public function getEvalue(): ?string
    {
        return $this->evalue;
    }

    public function setEvalue(?string $evalue): self
    {
        $this->evalue = $evalue;

        return $this;
    }
    
    public function getAiguille(): ?string
    {
        return $this->aiguille;
    }

    public function setAiguille(?string $aiguille): self
    {
        $this->aiguille = $aiguille;

        return $this;
    }
}
