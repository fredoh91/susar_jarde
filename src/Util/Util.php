<?php

namespace App\Util;

use \DateTime;
use App\Entity\Susar;
use App\Entity\Indications;
use App\Entity\Medicaments;
use App\Pemba\RequetesPemba;
use App\Entity\MedicalHistory;
use App\Meddra\RequetesMeddra;
use App\Entity\IntervenantsANSM;
use App\Entity\EffetsIndesirables;
use App\Pemba\RequetesPembaMedicaments;
use Doctrine\Persistence\ManagerRegistry;
use App\Pemba\RequetesPembaMedicalHistory;
use App\Pemba\RequetesPembaEffetsIndesirables;

// use App\Entity\TermeRechAttribDMMpole;
// use function PHPUnit\Framework\isNull;
// use function PHPUnit\Framework\isNull;

class Util
{
    /**
     * crée des enregistrements dans la table susar (et des tables liées) à partir des requêtes de la BNPV
     *
     * @param ManagerRegistry $doctrine
     * @param array $lstSusar resultat de la requête de la BNPV (array de SUSAR)
     * @param string $TypeSusar type de susar a créer : FR_DC_ProVit, TherapGen
     * @return void
     */


    public static function CreeSUSAR(ManagerRegistry $doctrine, array $lstSusar, string $TypeSusar, string $importTypeSusarEu): void
    {
        $entityManager = $doctrine->getManager();
        foreach ($lstSusar as $susar_a_creer) {
            if ($entityManager->getRepository(Susar::class)->EstCe_SUSAR_unique($susar_a_creer['id'])) {

                // pour récupérer le liste des indications
                $RqPemba = new RequetesPemba($doctrine);
                $RqPembaMedicaments = new RequetesPembaMedicaments($doctrine);
                $RqPembaEI = new RequetesPembaEffetsIndesirables($doctrine);
                $RqPembaMedHist = new RequetesPembaMedicalHistory($doctrine);
                $RqMeddra = new RequetesMeddra($doctrine);
                $IntervTherapGen = $entityManager->getRepository(IntervenantsANSM::class)->findOneDMM_pole_court('THÉRAPIE GÉNIQUE');
                $lstIndication = $RqPemba->donneListeIndicationMedSuspect_array($susar_a_creer['id']);
                $lstMed = $RqPembaMedicaments->donneMedicaments($susar_a_creer['id']);
                $lstEI = $RqPembaEI->donneEffetsIndesirables($susar_a_creer['id']);
                $lstMedHist = $RqPembaMedHist->donneMedicalHistories($susar_a_creer['id']);
                $medicament = $RqPemba->donneListeMedicament($susar_a_creer['id'], 'Suspect');
                $productName = $medicament['productname'];
                $substanceName = $medicament['substancename'];

                // le MasterId n'existe pas dans la table SUSAR, on peut le creer
                $Susar = new Susar();
                $Susar->setMasterId((int) $susar_a_creer['id']);
                $Susar->setCaseid((int) $susar_a_creer['caseid']);
                $Susar->setSpecificcaseid($susar_a_creer['specificcaseid']);
                $Susar->setDLPVersion($susar_a_creer['DLPVersion']);
                $Susar->setCreationdate(new DateTime($susar_a_creer['creationdate']));
                $Susar->setStatusdate(new DateTime($susar_a_creer['statusdate']));
                $Susar->setStudytitle($susar_a_creer['studytitle']);
                $Susar->setSponsorstudynumb($susar_a_creer['sponsorstudynumb']);
                $Susar->setNumEudract($susar_a_creer['num_eudract']);
                $Susar->setPaysEtude($susar_a_creer['pays_etude']);
                $Susar->setPaysSurvenue($susar_a_creer['pays_survenue']);
                $Susar->setTypeSusar($TypeSusar);
                $Susar->setProductName($productName);
                $Susar->setSubstanceName($substanceName);
                $Susar->setNarratif($susar_a_creer['narrativeincludeclinical']);
                $Susar->setPatientSex($susar_a_creer['patientsex']);
                $Susar->setPatientAge($susar_a_creer['patientonsetage']);
                $Susar->setPatientAgeUnitLabel($susar_a_creer['patientonsetageunitlabel']);
                $Susar->setPatientAgeGroup($susar_a_creer['patientagegroup']);
                $Susar->setIsCaseSerious($susar_a_creer['iscaseserious']);
                $Susar->setSeriousnessCriteria($susar_a_creer['seriousnesscriteria']);
                $Susar->setDateImport(new \DateTime());

                if ($TypeSusar === 'TherapGen') {
                    $Susar->setIntervenantANSM($IntervTherapGen);
                    $Susar->setDateAiguillage(new \DateTime());
                }

                // Ajout des médicaments dans l'entité Medicaments et gestion de la liaison avec l'entité Susar

                $NbMedicSuspect = 0;
                foreach ($lstMed as $medic_a_creer) {
                    if ($medic_a_creer['productcharacterization'] === 'Suspect') {
                        $NbMedicSuspect++;
                    }

                    if ($importTypeSusarEu === 'TRUE') {
                        $medic = new Medicaments;
                        $medic->setMasterId((int) $medic_a_creer['id']);
                        $medic->setCaseid((int) $medic_a_creer['caseid']);
                        $medic->setSpecificcaseid($medic_a_creer['specificcaseid']);
                        $medic->setDLPVersion($medic_a_creer['DLPVersion']);
                        $medic->setProductcharacterization($medic_a_creer['productcharacterization']);
                        $medic->setProductname($medic_a_creer['productname']);
                        $medic->setNBBlock($medic_a_creer['NBBlock']);
                        $medic->setSubstancename($medic_a_creer['substancename']);
                        $medic->setSusar($Susar);
                        $entityManager->persist($medic);
                        unset($medic);
                    }
                }
                $Susar->setNbMedicSuspect($NbMedicSuspect);

                // Ajout des indications dans l'entité Indications et gestion de la liaison avec l'entité Susar
                $IndicationEng = '';
                $Indication = '';

                foreach ($lstIndication as $indic_a_creer) {

                    if (is_null($indic_a_creer['codeproductindication'])) {
                        $indicationAnglaise = '';
                    } else {
                        $indicationAnglaise = (string) $RqMeddra->donneIndicEng_not_array($indic_a_creer['codeproductindication']);
                    }
                    $indicationFrancaise = (string) $indic_a_creer['productindication'];

                    if ($IndicationEng === '') {
                        $IndicationEng = $indicationAnglaise;
                    } else {
                        // on vérifie si la liste concaténée des indication en anglais, contient déjà cette indication
                        if (stripos($IndicationEng, $indicationAnglaise) === false) {
                            $IndicationEng .= ', ' . $indicationAnglaise;
                        }
                    }

                    if ($Indication === '') {
                        $Indication = $indicationFrancaise;
                    } else {
                        // on vérifie si la liste concaténée des indication en français, contient déjà cette indication
                        if (stripos($Indication, $indicationFrancaise) === false) {
                            $Indication .= ', ' . $indicationFrancaise;
                        }
                    }

                    if ($importTypeSusarEu === 'TRUE') {
                        $indic = new Indications();
                        $indic->setProductName((string) $indic_a_creer['productname']);
                        $indic->setCodeProductIndications((int) $indic_a_creer['codeproductindication']);
                        $indic->setProductIndications($indicationFrancaise);
                        $indic->setProductIndicationsEng($indicationAnglaise);
                        $indic->setProductcharacterization((string) 'Suspect');
                        $indic->setSusar($Susar);
                        $entityManager->persist($indic);
                        unset($indic);
                    }
                }

                $Susar->setIndication($Indication);
                $Susar->setIndicationEng($IndicationEng);

                if ($importTypeSusarEu === 'TRUE') {
                    // Ajout des EI dans l'entité EffetsIndesirables et gestion de la liaison avec l'entité Susar
                    foreach ($lstEI as $EI_a_creer) {
                        $EI = new EffetsIndesirables();
                        $EI->setMasterId((int) $EI_a_creer['id']);
                        $EI->setCaseid((int) $EI_a_creer['caseid']);
                        $EI->setSpecificcaseid($EI_a_creer['specificcaseid']);
                        $EI->setDLPVersion($EI_a_creer['DLPVersion']);
                        $EI->setReactionstartdate(new DateTime($EI_a_creer['reactionstartdate']));
                        $EI->setReactionmeddrallt($EI_a_creer['reactionmeddrallt']);
                        $EI->setCodereactionmeddrallt($EI_a_creer['codereactionmeddrallt']);
                        $EI->setReactionmeddrapt($EI_a_creer['reactionmeddrapt']);
                        $EI->setCodereactionmeddrapt($EI_a_creer['codereactionmeddrapt']);
                        $EI->setReactionmeddrahlt($EI_a_creer['reactionmeddrahlt']);
                        $EI->setCodereactionmeddrahlt($EI_a_creer['codereactionmeddrahlt']);
                        $EI->setReactionmeddrahlgt($EI_a_creer['reactionmeddrahlgt']);
                        $EI->setCodereactionmeddrahlgt($EI_a_creer['codereactionmeddrahlgt']);
                        $EI->setSoc($EI_a_creer['soc']);
                        $EI->setReactionmeddrasoc($EI_a_creer['reactionmeddrasoc']);
                        $EI->setSusar($Susar);
                        $entityManager->persist($EI);
                        unset($EI);
                    }

                    // Ajout des medical histories dans l'entité MedicalHistory et gestion de la liaison avec l'entité Susar

                    foreach ($lstMedHist as $MedHist_a_creer) {
                        $MedHist = new MedicalHistory();
                        $MedHist->setMasterId((int) $MedHist_a_creer['master_id']);
                        $MedHist->setDiseaseLibLLT($MedHist_a_creer['lib_LLT']);
                        $MedHist->setDiseaseCodeLLT((int) $MedHist_a_creer['code_LLT']);
                        $MedHist->setDiseaseLibPT($MedHist_a_creer['lib_PT']);
                        $MedHist->setDiseaseCodePT((int) $MedHist_a_creer['code_PT']);
                        $MedHist->setContinuing($MedHist_a_creer['patientmedicalcontinue']);
                        $MedHist->setMedicalcomment($MedHist_a_creer['patientmedicalcomment']);
                        $MedHist->setSusar($Susar);
                        $entityManager->persist($MedHist);
                        unset($MedHist);
                    }
                }

                $entityManager->persist($Susar);
                $entityManager->flush();
            }
        }
        return;
    }

    // /**
    //  * crée des médicaments dans la table Medicament à partir des requêtes de la BNPV
    //  *
    //  * @param ManagerRegistry $doctrine
    //  * @param array $TbEntree resultat de la requête de la BNPV
    //  * @return void
    //  */
    // public static function CreeMedicaments(ManagerRegistry $doctrine, array $TbEntree, int $susar_id): void
    // {
    //     $entityManager = $doctrine->getManager();
    //     foreach ($TbEntree as $medic_a_creer) {

    //         $medic = new Medicaments;
    //         $medic->setMasterId((int) $medic_a_creer['id']);
    //         $medic->setCaseid((int) $medic_a_creer['caseid']);
    //         $medic->setSpecificcaseid($medic_a_creer['specificcaseid']);
    //         $medic->setDLPVersion($medic_a_creer['DLPVersion']);
    //         $medic->setProductcharacterization($medic_a_creer['productcharacterization']);
    //         $medic->setProductname($medic_a_creer['productname']);
    //         $medic->setNBBlock($medic_a_creer['NBBlock']);
    //         $medic->setSubstancename($medic_a_creer['substancename']);
    //         $entityManager->persist($medic);
    //         $entityManager->flush();
    //     }
    //     return;
    // }
}
