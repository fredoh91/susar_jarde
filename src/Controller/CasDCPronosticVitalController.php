<?php

namespace App\Controller;

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
use App\Pemba\RequetesPemba;
use App\Entity\TermeRechAttribDMMpole;

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

    #[Route('/test_pemba_3', name: 'test_pemba_3')]
    public function test_pemba_3(ManagerRegistry $doctrine, Request $request): Response
    {
        $defaultData = ['message' => 'Saisissez une date d\'import'];
        $form = $this->createFormBuilder($defaultData)
            ->add('DateCreation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'date d\'import : ',
                'format' => 'yyyy-MM-dd',
                'input' => 'string',
            ])
            ->add('Recherche', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dateImport = $form->getData()['DateCreation'];

            $RqPemba = new RequetesPemba($doctrine);
            $stmt_2 = $RqPemba->donneListeEC_FrDC_FrPronVit($dateImport);

            return $this->render('cas_dc_pronostic_vital/RqPembaDate.html.twig', [
                'form' => $form->createView(),
                'em' => $stmt_2,
            ]);
        }
        return $this->render('cas_dc_pronostic_vital/RqPembaDate.html.twig', [
            'form' => $form->createView(),
            'em' => '',
        ]);
    }

    #[Route('/test_pemba_4', name: 'test_pemba_4')]
    public function test_pemba_4(ManagerRegistry $doctrine, Request $request): Response
    {
        $defaultData = ['message' => 'Saisissez une date d\'import'];
        $form = $this->createFormBuilder($defaultData)
        ->add('DateCreation', DateType::class, [
            'widget' => 'single_text',
            'label' => 'date d\'import : ',
            'format' => 'yyyy-MM-dd',
            'input' => 'string',
            ])
            ->add('Recherche', SubmitType::class)
            ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                $dateImport = $form->getData()['DateCreation'];
                
                $entityManager = $doctrine->getManager();
                $Lst_terapieGen = $entityManager->getRepository(TermeRechAttribDMMpole::class)->findAll();

                // Construit une liste de "TermeRech" séparés par des virgules pour faire une requête avec un WHERE ... IN ('jhj','hjhj','hjhjh','jkjl')
                foreach ($Lst_terapieGen as $ter) {
                    if (isset($lst) ) {
                        $lst .= ",'".$ter->getTermeRech()."'";
                    } else { 
                        $lst = "'".$ter->getTermeRech()."'"; 
                    }
                }

                $RqPemba = new RequetesPemba($doctrine);
                
                $cas_FrDC_FrPronVit = $RqPemba->donneListeEC_FrDC_FrPronVit($dateImport);
                $cas_TerapieGenique = $RqPemba->donneListeEC_TerapieGenique($dateImport, $lst);

                return $this->render('cas_dc_pronostic_vital/RqPembaDate.html.twig', [
                    'form' => $form->createView(),
                    'cas_FrDC_FrPronVit' => $cas_FrDC_FrPronVit,
                    'cas_TerapieGenique' => $cas_TerapieGenique,
                ]);
            }
            return $this->render('cas_dc_pronostic_vital/RqPembaDate.html.twig', [
                'form' => $form->createView(),
                'cas_FrDC_FrPronVit' => '',
                'cas_TerapieGenique' => '',
            ]);
    }




}
