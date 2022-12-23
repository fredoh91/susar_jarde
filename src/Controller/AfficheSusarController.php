<?php

namespace App\Controller;

use DateTime;
use App\Entity\Susar;
use App\Form\SusarType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AfficheSusarController extends AbstractController
{
    #[Route('/affiche_susar/{master_id}', name: 'app_affiche_susar')]
    public function index(int $master_id, ManagerRegistry $doctrine, Request $request,EntityManagerInterface $em): Response
    {
        // dd($master_id);

        $entityManager = $doctrine->getManager();
        $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($master_id);
        $form = $this->createForm(SusarType::class, $Susar);



        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // $data = $form->getData();
            if($form->get('SaveAndStop')->isClicked()) {
                // dump($data);
                $em->persist($Susar);
                $em->flush();

                $Susar = $entityManager->getRepository(Susar::class)->findByCreationdate($Susar->getCreationdate());

                if ($Susar[0] != null) {
                    $data = $Susar[0]->getCreationdate()->format('Y-m-d');
                } else {
                    $DateDuJour = new DateTime("now");
                    $data = $DateDuJour->format('Y-m-d');
                }

                $defaultData = ['message' => 'Saisissez une date d\'import'];

                $form = $this->createFormBuilder($defaultData)
                ->add('DateCreation', DateType::class, [
                    'widget' => 'single_text',
                    'label' => 'date d\'import : ',
                    'format' => 'yyyy-MM-dd',
                    'input' => 'string',
                    'data' => $data,
                    ])
                ->add('Recherche', SubmitType::class)
                ->getForm();

                // dd($Susar);
                return $this->render('cas_dc_pronostic_vital/RqSusarDate.html.twig', [
                    'form' => $form->createView(),
                    'Susar' => $Susar,
                ]); 



                // dd('On sauvegarde et on quitte');
            } else if ($form->get('SaveAndNext')->isClicked()) {
                $em->persist($Susar);
                $em->flush();
                // dd('On sauvegarde et on affiche le suivant');
            } else {
                dd('je sais pas quoi faire');
            }
        }
        


        // dd($Susar);
        // return $this->render('cas_dc_pronostic_vital/RqSusarDate.html.twig', [
        //     'form' => $form->createView(),
        //     'Susar' => $Susar,
        // ]);


        return $this->render('affiche_susar/index.html.twig', [
            'controller_name' => 'AfficheSusarController',
            'Susar' => $Susar,
            'form' => $form->createView(),
        ]);
    }
}
