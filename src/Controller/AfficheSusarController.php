<?php

namespace App\Controller;

use DateTime;
use App\Entity\Susar;
// use App\Form\SusarType;
use App\Form\EditSusarImportDmfrType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[Security("is_granted('ROLE_DMFR_GEST')")]
#[IsGranted('ROLE_DMFR_GEST')]
class AfficheSusarController extends AbstractController
{
    #[Route('/affiche_susar/{master_id}', name: 'app_affiche_susar')]
    public function index(int $master_id, ManagerRegistry $doctrine, Request $request, EntityManagerInterface $em): Response
    {
        $entityManager = $doctrine->getManager();
        $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($master_id);
        $form = $this->createForm(EditSusarImportDmfrType::class, $Susar);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            if($form->get('SaveAndStop')->isClicked()) {
                /**
                 *  On clique sur le bouton "Sauvegarder et quitter", ce qui :
                 *      - valide le cas en cours
                 *      - affiche la liste des cas pour le jour en cours
                 */
                $Susar->setDateAiguillage(new \DateTime());
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

                $NbSusar = count($Susar);
                return $this->render('import_susar/RqSusarDate.html.twig', [
                    'form' => $form->createView(),
                    'Susar' => $Susar,
                    'NbSusar' => $NbSusar,
                ]); 
            } else if ($form->get('SaveAndNext')->isClicked()) {
                /**
                 * On clique sur le bouton "Sauvegarder et suivant", ce qui :
                 *      - valide le cas affich??
                 *      - cherche le cas suivant
                 *      - si il y a un cas suivant, l'affiche et met a jour l'URL avec l'ID de ce cas suivant
                 */
                
                $Susar->setDateAiguillage(new \DateTime());
                $creationdate = $Susar->getCreationdate();
                $master_id = $Susar->getMasterId();
                $em->persist($Susar);
                $em->flush();
                $next_master_id=$entityManager->getRepository(Susar::class)->findNextMasterIdByCreationdate( $creationdate,  $master_id);
                if($next_master_id === 0) {
                    //////////////////////////////////////////////////////////////////////////////////
                    // C'est le dernier SUSAR de la liste, on retourne a la liste des SUSAR du jour //
                    //////////////////////////////////////////////////////////////////////////////////

                    return $this->redirectToRoute('RqSusarDateAffDate', [
                        'creationdate' => $Susar->getCreationdate()->format('Y-m-d'),
                    ]); 
                    
                } else {
                    //////////////////////////////////////////////////////////////////////////////////////////////
                    // Ce n'est pas le dernier SUSAR de la liste, on affiche le SUSAR suivant : $next_master_id //
                    //////////////////////////////////////////////////////////////////////////////////////////////

                    $entityManager = $doctrine->getManager();
                    $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($next_master_id);
                    $form = $this->createForm(EditSusarImportDmfrType::class, $Susar);

                    return $this->redirectToRoute('app_affiche_susar', [
                        'master_id' => $next_master_id,
                    ]); 
                };
                // dd('On sauvegarde et on affiche le suivant');
            } else {
                dd('je sais pas quoi faire');
            }
        }
        
        return $this->render('import_susar/affiche_susar.html.twig', [
            'Susar' => $Susar,
            'form' => $form->createView(),
        ]);
    }
}
