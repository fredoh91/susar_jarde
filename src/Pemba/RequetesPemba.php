<?php

namespace App\Pemba;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class RequetesPemba
{
    private $em;
    private $doctrine;
    function __construct(ManagerRegistry $doctrine)
    {
        // $this->dateCreation = $dateCreation;
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager('pemba');
    }

    function donneListeEC_FrDC_FrPronVit (string $dateCreation): array {

        $sql = "SELECT DISTINCT " 
        // . "  mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion, id.worldwideuniquecaseidentificationnumber, " 
        // . "  ci.iscaseserious, ci.seriousnesscriteria, ci.receivedate, mo.receiptdate, mv.creationdate, mv.statusdate, " 
        // . "  pa.patientsex, pa.patientonsetage, pa.patientonsetageunitlabel, pa.patientagegroup, " 
        // . "  ps.reportercountry, " 
        // . "  na.narrativeincludeclinical, cs.casesummarylanguage, cs.casesummary " 
        . "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion, mv.creationdate, mv.statusdate, "
        . "st.studytitle, st.sponsorstudynumb, "
        . "sr.studyname num_eudract, sr.studyregistrationcountry pays_etude, "
        . "id.worldwideuniquecaseidentificationnumber, "
        . "ci.iscaseserious, ci.seriousnesscriteria, ci.receivedate, "
        . "mo.receiptdate, "
        . "pa.patientsex, pa.patientonsetage, pa.patientonsetageunitlabel, pa.patientagegroup, "
        . "ps.reportercountry, "
        . "na.narrativeincludeclinical, "
        . "cs.casesummarylanguage, cs.casesummary "
        . "FROM master_versions mv " 
        // . "INNER JOIN bi_mostrecentinformation mo ON mv.id = mo.master_id " 
        . "INNER JOIN (SELECT master_id, MAX(receiptdate) AS receiptdate FROM bi_mostrecentinformation GROUP BY master_id) AS mo ON mv.id = mo.master_id "
        . "INNER JOIN bi_caseinfo ci ON mv.id = ci.master_id " 
        . "INNER JOIN bi_identifiers id ON mv.id = id.master_id " 
        . "INNER JOIN bi_patientinformations pa ON mv.id = pa.master_id " 
        . "INNER JOIN bi_primarysource ps ON mv.id = ps.master_id " 
        . "LEFT JOIN bi_narrative na ON mv.id = na.master_id " 
        . "LEFT JOIN bi_case_summary cs ON mv.id = cs.master_id " 
        . "LEFT JOIN bi_study st ON mv.id = st.master_id "
        . "LEFT JOIN bi_study_registration sr ON mv.id = sr.master_id "
        . "WHERE 1 = 1 " 
        . "AND specificcaseid LIKE 'EC%' " 
        . "AND mv.CreationDate = '" . $dateCreation . "' " 
        . "AND mv.Deleted = 0 " 
        . "AND ps.primarysourceforregulatorypurposes LIKE 'Yes' " 
        . "AND (ci.seriousnesscriteria LIKE '%Death%' OR ci.seriousnesscriteria LIKE '%Life Threatening%') " 
        . "AND ps.reportercountry = 'FR' "
        . "ORDER BY mv.id;";
            
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2= $stmt->execute()->fetchAll(); 

        return $stmt_2;

    }

    function donneListeEC_TerapieGenique (string $dateCreation,string $LstTerapie): array {
        
        $sql = "SELECT DISTINCT "
        . "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion, mv.creationdate, mv.statusdate, "
        . "st.studytitle, st.sponsorstudynumb, "
        . "sr.studyname num_eudract, sr.studyregistrationcountry pays_etude, "
        . "id.worldwideuniquecaseidentificationnumber, "
        . "ci.iscaseserious, ci.seriousnesscriteria, ci.receivedate, "
        . "mo.receiptdate, "
        . "pa.patientsex, pa.patientonsetage, pa.patientonsetageunitlabel, pa.patientagegroup, "
        . "ps.reportercountry, "
        . "na.narrativeincludeclinical, "
        . "cs.casesummarylanguage, cs.casesummary "
        . "FROM master_versions mv "
        . "LEFT JOIN bi_study st ON mv.id = st.master_id "
        . "LEFT JOIN bi_study_registration sr ON mv.id = sr.master_id "
        . "INNER JOIN bi_identifiers id ON mv.id = id.master_id "
        . "INNER JOIN bi_caseinfo ci ON mv.id = ci.master_id "
        . "INNER JOIN (SELECT master_id, MAX(receiptdate) AS receiptdate FROM bi_mostrecentinformation GROUP BY master_id) AS mo ON mv.id = mo.master_id "
        . "INNER JOIN bi_patientinformations pa ON mv.id = pa.master_id "
        . "INNER JOIN bi_primarysource ps ON mv.id = ps.master_id "
        . "LEFT JOIN bi_narrative na ON mv.id = na.master_id "
        . "LEFT JOIN bi_case_summary cs ON mv.id = cs.master_id "
        . "WHERE 1 = 1 "
        . "AND specificcaseid LIKE 'EC%' "
        . "AND mv.CreationDate = '" . $dateCreation . "' " 
        . "AND mv.Deleted = 0 "
        . "AND ps.primarysourceforregulatorypurposes LIKE 'Yes' " 
        . "AND sr.studyname IN (".$LstTerapie.") "
        . "ORDER BY mv.id;";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2= $stmt->execute()->fetchAll(); 

        return $stmt_2;

    }
}
