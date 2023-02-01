<?php

namespace App\Util;

use \DateTime;
use App\Entity\Susar;
// use App\Entity\TermeRechAttribDMMpole;
// use function PHPUnit\Framework\isNull;
use App\Pemba\RequetesPemba;
use App\Meddra\RequetesMeddra;
use Doctrine\Persistence\ManagerRegistry;

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
                $RqMeddra = new RequetesMeddra($doctrine);
                $Indication = $RqPemba->donneListeIndication($susar_a_creer['id']);
                $Indication = mb_convert_encoding($Indication, 'UTF-8');
                $CodeIndication = $RqPemba->donneListeCodeIndication($susar_a_creer['id']);
                // $IndicationEng = $RqMeddra->donneIndicEng_UnCode($CodeIndication[0]);
                $IndicationEng = $RqMeddra->donneIndicEng($CodeIndication);

                // dd($IndicationEng);

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
                $entityManager->persist($Susar);
                $entityManager->flush();
            }
        }
        return;
    }
}
