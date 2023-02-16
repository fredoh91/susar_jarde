<?php

namespace App\Pemba;

use Doctrine\Persistence\ManagerRegistry;

class RequetesPembaEffetsIndesirables
{
    private $em;
    private $doctrine;
    // private $master_id;
    // private $susar_id;, int $master_id, int $susar_id


    public function __construct(ManagerRegistry $doctrine)
    {

        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager('pemba');

    }

    public function donneEffetsIndesirables (int $master_id) {

        $sql = "SELECT DISTINCT "
        . "mv.id, "
        . "mv.caseid, "
        . "mv.specificcaseid, "
        . "mv.DLPVersion, "
        . "re.reactionstartdate, "
        . "re.reactionmeddrallt, "
        . "re.codereactionmeddrallt, "
        . "re.reactionmeddrapt, "
        . "re.codereactionmeddrapt, "
        . "re.reactionmeddrahlt, "
        . "re.codereactionmeddrahlt, "
        . "re.reactionmeddrahlgt, "
        . "re.codereactionmeddrahlgt, "
        . "re.reactionmeddrasoc, "
        . "re.soc "
        . "FROM master_versions mv "
        . "INNER JOIN bi_reaction re ON mv.id = re.master_id "
        . "WHERE "
        . "1 = 1 "
        . "AND specificcaseid LIKE 'EC%' "
        . "AND mv.id = " . $master_id . " "
        . "AND mv.Deleted = 0; ";
        

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();
        return $stmt_2;
    }

}
