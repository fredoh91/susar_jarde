<?php

namespace App\Controller;

use App\Entity\Susar;
// use App\Form\EvalSusarType;
use App\Form\EditSusarEvalType;
// use App\Form\EvalSusarPostSaisieType;
use App\Form\SusarPostSaisieEvalType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Security("is_granted('ROLE_DMM_EVAL') or is_granted('ROLE_SURV_PILOTEVEC')")]
class AfficheEvalSusarController extends AbstractController
{
    #[Route('/affiche_eval_susar/{master_id}', name: 'app_affiche_eval_susar')]
    public function index(int $master_id, ManagerRegistry $doctrine, Request $request, EntityManagerInterface $em): Response
    {
        $entityManager = $doctrine->getManager();
        $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($master_id);
        // $form = $this->createForm(EvalSusarType::class, $Susar);
        $form = $this->createForm(EditSusarEvalType::class, $Susar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Susar->setDateEvaluation(new \DateTime());
// dd( $Susar);
            $em->persist($Susar);
            $em->flush();
            $this->addFlash('success', 'Votre évaluation a bien été prise en compte, vous pouvez fermer cet onglet.');
            return $this->redirectToRoute('app_affiche_eval_susar_post_saisie', [
                'master_id' => $master_id,
            ]); 
        }

        return $this->render('eval_susar/affiche_eval_susar.html.twig', [
            'Susar' => $Susar,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/affiche_eval_susar_post_saisie/{master_id}', name: 'app_affiche_eval_susar_post_saisie')]
    public function post_saisie(int $master_id, ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($master_id);
        // $form = $this->createForm(EvalSusarPostSaisieType::class, $Susar);
        $form = $this->createForm(SusarPostSaisieEvalType::class, $Susar);
        // $form = $this->createForm(EvalSusarType::class, $Susar, [
        //     'attr' => 'ReadOnly',
        // ]);
        $form->handleRequest($request);


        return $this->render('eval_susar/affiche_eval_susar_post_saisie.html.twig', [
            'Susar' => $Susar,
            'form' => $form->createView(),
        ]);
    }
}
