<?php

namespace App\Util;

use \DateTime;
use App\Entity\Susar;
use App\Entity\Medicaments;
use App\Entity\EffetsIndesirables;
// use App\Entity\TermeRechAttribDMMpole;
// use function PHPUnit\Framework\isNull;
use App\Pemba\RequetesPemba;
use App\Meddra\RequetesMeddra;
use App\Pemba\RequetesPembaMedicaments;
use Doctrine\Persistence\ManagerRegistry;
use App\Pemba\RequetesPembaEffetsIndesirables;

class Util
{
    /**
     * crée des enregistrement dans la table susar à partir des requêtes de la BNPV
     *
     * @param ManagerRegistry $doctrine
     * @param array $TbEntree resultat de la requête de la BNPV
     * @param string $TypeSusar type de susar a créer : FR_DC_ProVit, TherapGen
     * @return void
     */
    public static function CreeSUSAR(ManagerRegistry $doctrine, array $TbEntree, string $TypeSusar): void
    {
        $entityManager = $doctrine->getManager();
        foreach ($TbEntree as $susar_a_creer) {
            if ($entityManager->getRepository(Susar::class)->EstCe_SUSAR_unique($susar_a_creer['id'])) {

                // pour récupérer le liste des indications
                $RqPemba = new RequetesPemba($doctrine);
                $RqPembaMedicaments = new RequetesPembaMedicaments($doctrine);
                $RqPembaEI = new RequetesPembaEffetsIndesirables($doctrine);
                $RqMeddra = new RequetesMeddra($doctrine);
                $Indication = $RqPemba->donneListeIndication($susar_a_creer['id']);
                $Indication = mb_convert_encoding($Indication, 'UTF-8');
                $CodeIndication = $RqPemba->donneListeCodeIndication($susar_a_creer['id']);
                // $IndicationEng = $RqMeddra->donneIndicEng_UnCode($CodeIndication[0]);
                $IndicationEng = $RqMeddra->donneIndicEng($CodeIndication);
                $lstMed = $RqPembaMedicaments->donneMedicaments($susar_a_creer['id']);
                $lstEI = $RqPembaEI->donneEffetsIndesirables($susar_a_creer['id']);
                $medicament = $RqPemba->donneListeMedicament($susar_a_creer['id'], 'Suspect');
                $productName = $medicament['productname'];
                $substanceName = $medicament['substancename'];
                // dump($susar_a_creer['id'], $productName);

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
                $Susar->setTypeSusar($TypeSusar);
                $Susar->setIndication($Indication);
                $Susar->setIndicationEng($IndicationEng);
                $Susar->setProductName($productName);
                $Susar->setSubstanceName($substanceName);

                // Ajout des médicmaments dans l'entité Medicaments et gestion de la liaison avec l'entité Susar
                foreach ($lstMed as $medic_a_creer) {

                    // dump($medic_a_creer);
        
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
                    // $entityManager->flush();
                }


                // Ajout des EI dans l'entité EffetsIndesirables et gestion de la liaison avec l'entité Susar
                foreach ($lstEI as $EI_a_creer) {

                    // dump($EI_a_creer);
        
                    $EI = new EffetsIndesirables;
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
                    // $entityManager->flush();
                }

                $entityManager->persist($Susar);
                $entityManager->flush();

                // $susar_id = $Susar->getId();

                // $lstMed = $RqPembaMedicaments->donneMedicaments($susar_a_creer['id']);

                // // dd($lstMed);
                // self::CreeMedicaments($doctrine, $lstMed);
            }
        }
        return;
    }

    /**
     * crée des médicaments dans la table Medicament à partir des requêtes de la BNPV
     *
     * @param ManagerRegistry $doctrine
     * @param array $TbEntree resultat de la requête de la BNPV
     * @return void
     */
    public static function CreeMedicaments(ManagerRegistry $doctrine, array $TbEntree, int $susar_id): void
    {
        $entityManager = $doctrine->getManager();
        foreach ($TbEntree as $medic_a_creer) {

            dump($medic_a_creer);

            $medic = new Medicaments;
            // $medic->setId((int) $susar_id);
            $medic->setMasterId((int) $medic_a_creer['id']);
            $medic->setCaseid((int) $medic_a_creer['caseid']);
            $medic->setSpecificcaseid($medic_a_creer['specificcaseid']);
            $medic->setDLPVersion($medic_a_creer['DLPVersion']);
            $medic->setProductcharacterization($medic_a_creer['productcharacterization']);
            $medic->setProductname($medic_a_creer['productname']);
            $medic->setNBBlock($medic_a_creer['NBBlock']);
            $medic->setSubstancename($medic_a_creer['substancename']);
            $entityManager->persist($medic);
            $entityManager->flush();
        }
        return;
    }
}
