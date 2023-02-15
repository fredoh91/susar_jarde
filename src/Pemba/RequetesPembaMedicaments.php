<?php

namespace App\Pemba;

use Doctrine\Persistence\ManagerRegistry;

class RequetesPembaMedicaments
{
    private $em;
    private $doctrine;
    // private $master_id;
    // private $susar_id;, int $master_id, int $susar_id


    public function __construct(ManagerRegistry $doctrine)
    {
        // $this->dateCreation = $dateCreation;
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager('pemba');

    }

    public function donneMedicaments (int $master_id) {

        $sql = "SELECT DISTINCT "
        . "mv.id, "
        . "mv.caseid, "
        . "mv.specificcaseid, "
        . "mv.DLPVersion, "
        . "pr.productcharacterization, "
        . "TRIM(REPLACE(pr.productname, '\n', '')) productname, "
        . "pr.NBBlock, "
        . "su.substancename "
        . "FROM master_versions mv "
        . "INNER JOIN bi_product pr ON mv.id = pr.master_id "
        . "LEFT JOIN bi_product_substance su ON pr.master_id = su.master_id AND pr.NBBlock = su.NBBlock "
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
