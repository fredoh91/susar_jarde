<?php

namespace App\Pemba;

use Doctrine\Persistence\ManagerRegistry;

class RequetesPembaMedicalHistory
{
    private $em;
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {

        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager('pemba');
    }

    public function donneMedicalHistories(int $master_id)
    {

        $sql = "SELECT DISTINCT "
            . "master_id, "
            . "patientepisodenameasreported, "
            . "patientepisodecode code_LLT, "
            . "patientepisodename lib_LLT, "
            . "codepatientepisodemeddrapt code_PT, "
            . "patientepisodemeddrapt lib_PT, "
            . "patientepisodesoccode, "
            . "patientepisodesocname, "
            . "patientepisodenamemeddraversion, "
            . "patientmedicalcontinue, "
            . "patientmedicalenddate, "
            . "patientmedicalstartdate, "
            . "familyhistory, "
            . "patientmedicalcomment "
            . "FROM bi_medhistory "
            . "WHERE master_id = " . $master_id . " ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();
        return $stmt_2;
    }
}
