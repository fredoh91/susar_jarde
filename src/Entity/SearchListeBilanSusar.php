<?php

namespace App\Entity;

use DateTime;

class SearchListeBilanSusar
{
    private ?\DateTimeInterface $debutStatusDate = null;
    private ?\DateTimeInterface $finStatusDate = null;
    // private ?\DateTimeInterface $debutDateImport = null;
    // private ?\DateTimeInterface $finDateImport = null;

    public function __construct( ?\DateTimeInterface $debutStatusDate = null ,  ?\DateTimeInterface $finStatusDate = null) {
        if (is_null($debutStatusDate)) {
            $this->debutStatusDate = DateTime::createFromFormat('m-d-Y', '01-01-2023');
        } else {
            $this->debutStatusDate = $debutStatusDate;
        }
        
        if (is_null($finStatusDate)) {
            $this->finStatusDate =  new DateTime("now");
        } else {
            $this->finStatusDate = $finStatusDate;
        }
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
    

    // public function getDebutDateImport(): ?\DateTimeInterface
    // {
    //     return $this->debutDateImport;
    // }

    // public function setDebutDateImport(?\DateTimeInterface $debutDateImport): self
    // {
    //     $this->debutDateImport = $debutDateImport;

    //     return $this;
    // }
    
    // public function getFinDateImport(): ?\DateTimeInterface
    // {
    //     return $this->finDateImport;
    // }

    // public function setFinDateImport(?\DateTimeInterface $finDateImport): self
    // {
    //     $this->finDateImport = $finDateImport;

    //     return $this;
    // }
    
}
