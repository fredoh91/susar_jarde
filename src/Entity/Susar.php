<?php

namespace App\Entity;

use App\Repository\SusarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $indication_eng = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $substanceName = null;

    #[ORM\ManyToOne(inversedBy: 'susars')]
    private ?MesureAction $MesureAction = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Commentaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEvaluation = null;

    #[ORM\OneToMany(mappedBy: 'susar', targetEntity: Medicaments::class)]
    private Collection $Medicament;

    #[ORM\OneToMany(mappedBy: 'susar', targetEntity: EffetsIndesirables::class)]
    private Collection $EffetsIndesirables;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $narratif = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays_survenue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAiguillage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateImport = null;

    #[ORM\Column(nullable: true)]
    private ?int $NbMedicSuspect = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $patientAgeGroup = null;

    #[ORM\Column(nullable: true)]
    private ?float $patientAge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $patientAgeUnitLabel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $isCaseSerious = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $seriousnessCriteria = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $patientSex = null;

    #[ORM\OneToMany(mappedBy: 'susar', targetEntity: Indications::class)]
    private Collection $IndicationsTable;

    #[ORM\OneToMany(mappedBy: 'susar', targetEntity: MedicalHistory::class)]
    private Collection $medicalHistories;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $worldWide_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $seriousnessCriteria_brut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $utilisateurEvaluation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $utilisateurAiguillage = null;

    public function __construct()
    {
        $this->Medicament = new ArrayCollection();
        $this->EffetsIndesirables = new ArrayCollection();
        $this->IndicationsTable = new ArrayCollection();
        $this->medicalHistories = new ArrayCollection();
    }

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

    public function getIndicationEng(): ?string
    {
        return $this->indication_eng;
    }

    public function setIndicationEng(?string $indication_eng): self
    {
        $this->indication_eng = $indication_eng;

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

    public function getMesureAction(): ?MesureAction
    {
        return $this->MesureAction;
    }

    public function setMesureAction(?MesureAction $MesureAction): self
    {
        $this->MesureAction = $MesureAction;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(?string $Commentaire): self
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }

    public function getDateEvaluation(): ?\DateTimeInterface
    {
        return $this->dateEvaluation;
    }

    public function setDateEvaluation(?\DateTimeInterface $dateEvaluation): self
    {
        $this->dateEvaluation = $dateEvaluation;

        return $this;
    }

    /**
     * @return Collection<int, Medicaments>
     */
    public function getMedicament(): Collection
    {
        return $this->Medicament;
    }

    public function addMedicament(Medicaments $medicament): self
    {
        if (!$this->Medicament->contains($medicament)) {
            $this->Medicament->add($medicament);
            $medicament->setSusar($this);
        }

        return $this;
    }

    public function removeMedicament(Medicaments $medicament): self
    {
        if ($this->Medicament->removeElement($medicament)) {
            // set the owning side to null (unless already changed)
            if ($medicament->getSusar() === $this) {
                $medicament->setSusar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EffetsIndesirables>
     */
    public function getEffetsIndesirables(): Collection
    {
        return $this->EffetsIndesirables;
    }

    public function addEffetsIndesirable(EffetsIndesirables $effetsIndesirable): self
    {
        if (!$this->EffetsIndesirables->contains($effetsIndesirable)) {
            $this->EffetsIndesirables->add($effetsIndesirable);
            $effetsIndesirable->setSusar($this);
        }

        return $this;
    }

    public function removeEffetsIndesirable(EffetsIndesirables $effetsIndesirable): self
    {
        if ($this->EffetsIndesirables->removeElement($effetsIndesirable)) {
            // set the owning side to null (unless already changed)
            if ($effetsIndesirable->getSusar() === $this) {
                $effetsIndesirable->setSusar(null);
            }
        }

        return $this;
    }

    public function getNarratif(): ?string
    {
        return $this->narratif;
    }

    public function setNarratif(?string $narratif): self
    {
        $this->narratif = $narratif;

        return $this;
    }

    public function getPaysSurvenue(): ?string
    {
        return $this->pays_survenue;
    }

    public function setPaysSurvenue(?string $pays_survenue): self
    {
        $this->pays_survenue = $pays_survenue;

        return $this;
    }

    public function getDateAiguillage(): ?\DateTimeInterface
    {
        return $this->dateAiguillage;
    }

    public function setDateAiguillage(?\DateTimeInterface $dateAiguillage): self
    {
        $this->dateAiguillage = $dateAiguillage;

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

    public function getNbMedicSuspect(): ?int
    {
        return $this->NbMedicSuspect;
    }

    public function setNbMedicSuspect(?int $NbMedicSuspect): self
    {
        $this->NbMedicSuspect = $NbMedicSuspect;

        return $this;
    }

    public function getPatientAgeGroup(): ?string
    {
        return $this->patientAgeGroup;
    }

    public function setPatientAgeGroup(?string $patientAgeGroup): self
    {
        $this->patientAgeGroup = $patientAgeGroup;

        return $this;
    }

    public function getPatientAge(): ?float
    {
        return $this->patientAge;
    }

    public function setPatientAge(?float $patientAge): self
    {
        $this->patientAge = $patientAge;

        return $this;
    }

    public function getPatientAgeUnitLabel(): ?string
    {
        return $this->patientAgeUnitLabel;
    }

    public function setPatientAgeUnitLabel(?string $patientAgeUnitLabel): self
    {
        $this->patientAgeUnitLabel = $patientAgeUnitLabel;

        return $this;
    }

    public function getIsCaseSerious(): ?string
    {
        return $this->isCaseSerious;
    }

    public function setIsCaseSerious(?string $isCaseSerious): self
    {
        $this->isCaseSerious = $isCaseSerious;

        return $this;
    }

    public function getSeriousnessCriteria(): ?string
    {
        return $this->seriousnessCriteria;
    }

    public function setSeriousnessCriteria(?string $seriousnessCriteria): self
    {
        $this->seriousnessCriteria = $seriousnessCriteria;

        return $this;
    }

    public function getPatientSex(): ?string
    {
        return $this->patientSex;
    }

    public function setPatientSex(?string $patientSex): self
    {
        $this->patientSex = $patientSex;

        return $this;
    }

    /**
     * @return Collection<int, Indications>
     */
    public function getIndicationsTable(): Collection
    {
        return $this->IndicationsTable;
    }

    public function addIndicationsTable(Indications $IndicationsTable): self
    {
        if (!$this->IndicationsTable->contains($IndicationsTable)) {
            $this->IndicationsTable->add($IndicationsTable);
            $IndicationsTable->setSusar($this);
        }

        return $this;
    }

    public function removeIndicationsTable(Indications $IndicationsTable): self
    {
        if ($this->IndicationsTable->removeElement($IndicationsTable)) {
            // set the owning side to null (unless already changed)
            if ($IndicationsTable->getSusar() === $this) {
                $IndicationsTable->setSusar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MedicalHistory>
     */
    public function getMedicalHistories(): Collection
    {
        return $this->medicalHistories;
    }

    public function addMedicalHistory(MedicalHistory $medicalHistory): self
    {
        if (!$this->medicalHistories->contains($medicalHistory)) {
            $this->medicalHistories->add($medicalHistory);
            $medicalHistory->setSusar($this);
        }

        return $this;
    }

    public function removeMedicalHistory(MedicalHistory $medicalHistory): self
    {
        if ($this->medicalHistories->removeElement($medicalHistory)) {
            // set the owning side to null (unless already changed)
            if ($medicalHistory->getSusar() === $this) {
                $medicalHistory->setSusar(null);
            }
        }

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

    public function getSeriousnessCriteriaBrut(): ?string
    {
        return $this->seriousnessCriteria_brut;
    }

    public function setSeriousnessCriteriaBrut(?string $seriousnessCriteria_brut): self
    {
        $this->seriousnessCriteria_brut = $seriousnessCriteria_brut;

        return $this;
    }

    public function getUtilisateurEvaluation(): ?string
    {
        return $this->utilisateurEvaluation;
    }

    public function setUtilisateurEvaluation(?string $utilisateurEvaluation): self
    {
        $this->utilisateurEvaluation = $utilisateurEvaluation;

        return $this;
    }

    public function getUtilisateurAiguillage(): ?string
    {
        return $this->utilisateurAiguillage;
    }

    public function setUtilisateurAiguillage(?string $utilisateurAiguillage): self
    {
        $this->utilisateurAiguillage = $utilisateurAiguillage;

        return $this;
    }

}
