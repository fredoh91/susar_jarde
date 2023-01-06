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
                /**
                 *  On clique sur le bouton "Sauvegarder et quitter", ce qui :
                 *      - valide le cas en cours
                 *      - affiche la liste des cas pour le jour en cours
                 */
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
                /**
                 * On clique sur le bouton "Sauvegarder et suivant", ce qui :
                 *      - valide le cas affiché
                 *      - cherche le cas suivant
                 *      - si il y a un cas suivant, l'affiche et met a jour l'URL avec l'ID de ce cas suivant
                 */
                // dump($Susar);
                $creationdate = $Susar->getCreationdate();
                $master_id = $Susar->getMasterId();
                $em->persist($Susar);
                $em->flush();
                $next_master_id=$entityManager->getRepository(Susar::class)->findNextMasterIdByCreationdate( $creationdate,  $master_id);
                dump("next_master_id : " . $next_master_id);
                if($next_master_id === 0) {
                    
                    // C'est le dernier SUSAR de la liste, on retourne a la liste des SUSAR du jour
                    // dump("Susar.Id: " . $Susar->getId());
                    // var_dump("Susar.Creationdate: " . $Susar->getCreationdate()->format('Y-m-d'));
                    // if ($Susar[0] != null) {
                    // if ($Susar->getCreationdate() != null) {
                    //     $data = $Susar->getCreationdate()->format('Y-m-d');
                    // } else {
                    //     $DateDuJour = new DateTime("now");
                    //     $data = $DateDuJour->format('Y-m-d');
                    // }
    
                    // $defaultData = ['message' => 'Saisissez une date d\'import'];
    
                    // $form = $this->createFormBuilder($defaultData)
                    // ->add('DateCreation', DateType::class, [
                    //     'widget' => 'single_text',
                    //     'label' => 'date d\'import : ',
                    //     'format' => 'yyyy-MM-dd',
                    //     'input' => 'string',
                    //     'data' => $data,
                    //     ])
                    // ->add('Recherche', SubmitType::class)
                    // ->getForm();
    
                    // // dd($Susar);
                    // return $this->render('cas_dc_pronostic_vital/RqSusarDate.html.twig', [
                    //     'form' => $form->createView(),
                    //     'Susar' => $Susar,
                    // ]);


                    return $this->redirectToRoute('RqSusarDateAffDate', [
                        'creationdate' => $Susar->getCreationdate()->format('Y-m-d'),
                    ]); 
                    

                } else {
                    // Ce n'est pas le dernier SUSAR de la liste, on affiche le SUSAR suivant : $next_master_id
                    $entityManager = $doctrine->getManager();
                    $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($next_master_id);
                    $form = $this->createForm(SusarType::class, $Susar);

                    // return $this->render('affiche_susar/index.html.twig', [
                    //     'master_id' => $next_master_id,
                    //     'Susar' => $Susar,
                    //     'form' => $form->createView(),
                    // ]);

                    // return $this->redirectToRoute('app_affiche_susar', [
                    //     'master_id' => $next_master_id,
                    //     'form' => $form->createView(),
                    //     'Susar' => $Susar,
                    // ]); 
                    
                    // dump($next_master_id);

                    return $this->redirectToRoute('app_affiche_susar', [
                        'master_id' => $next_master_id,
                    ]); 
                };
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
            'Susar' => $Susar,
            'form' => $form->createView(),
        ]);
    }
}
