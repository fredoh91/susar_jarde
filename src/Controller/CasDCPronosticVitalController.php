<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CasDCPronosticVitalController extends AbstractController
{
    private $em;
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    // #[Route('/cas_dc_pronostic_vital', name: 'app_cas_d_c_pronostic_vital')]
    // public function index(): Response
    // {
    //     return $this->render('cas_dc_pronostic_vital/index.html.twig', [
    //         'controller_name' => 'CasDCPronosticVitalController',
    //     ]);
    // }
    #[Route('/test_pemba', name: 'test_pemba')]
    public function test_pemba(EntityManagerInterface $em): Response
    {
        return $this->render('cas_dc_pronostic_vital/index.html.twig', [
            'controller_name' => 'CasDCPronosticVitalController',
            'em' => $em,
        ]);
    }
    #[Route('/test_pemba_2', name: 'test_pemba_2')]
    public function test_pemba_2(ManagerRegistry $doctrine): Response
    {
        
        $this->em = $doctrine->getManager('pemba');
        // $sql = "UPDATE grille_occ_em_v2 SET vmin=$this->vmin_3, vmax=$this->vmax_3 WHERE cat_idx=3;";



        $sql = "SELECT DISTINCT "
             .  "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion, " 
             .  "st.studytitle, st.sponsorstudynumb, "
             .  "sr.studyname num_eudract, sr.studyregistrationcountry pays_etude "
             .  "FROM master_versions mv "
             .  "LEFT JOIN bi_study st ON mv.id = st.master_id "
             .  "LEFT JOIN bi_study_registration sr ON mv.id = sr.master_id "
             .  "WHERE 1 = 1 "
             .  "AND specificcaseid LIKE 'EC%' "
             .  "AND mv.CreationDate = '2022-09-30' "
             .  "AND mv.Deleted = 0;";


        
             $stmt = $this->em->getConnection()->prepare($sql);
             $stmt_2= $stmt->execute()->fetchAll(); 
            //  $stmt_2= $stmt->execute(); 



        return $this->render('cas_dc_pronostic_vital/index.html.twig', [
            'controller_name' => 'CasDCPronosticVitalController',
            'em' => $stmt_2,
        ]);
    }
}
