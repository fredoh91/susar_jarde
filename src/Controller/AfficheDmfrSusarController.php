<?php

namespace App\Controller;

use App\Entity\Susar;
// use App\Form\DmfrSusarType;
use App\Form\EditSusarDmfrType;
// use App\Form\EditSusarEvalType;
// use App\Form\DmfrSusarPostSaisieType;
use App\Form\SusarPostSaisieDmfrType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[Security("is_granted('ROLE_DMFR_REF') or is_granted('ROLE_SURV_PILOTEVEC')")]
// #[IsGranted('ROLE_DMFR_REF')]
// #[IsGranted('ROLE_SURV_PILOTEVEC')]
#[IsGranted(new Expression('is_granted("ROLE_DMFR_REF") or is_granted("ROLE_SURV_PILOTEVEC")'))]
class AfficheDmfrSusarController extends AbstractController
{
    #[Route('/affiche_dmfr_susar/{master_id}', name: 'app_affiche_dmfr_susar')]
    public function index(int $master_id, ManagerRegistry $doctrine, Request $request, EntityManagerInterface $em): Response
    {
        $entityManager = $doctrine->getManager();
        $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($master_id);
        // $form = $this->createForm(DmfrSusarType::class, $Susar);
        $form = $this->createForm(EditSusarDmfrType::class, $Susar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($Susar);
            $em->flush();
            $this->addFlash('success', 'Votre évaluation a bien été prise en compte, vous pouvez fermer cet onglet.');
            return $this->redirectToRoute('app_affiche_dmfr_susar_post_saisie', [
                'master_id' => $master_id,
            ]); 
        }

        return $this->render('eval_susar/affiche_dmfr_susar.html.twig', [
            'Susar' => $Susar,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/affiche_dmfr_susar_post_saisie/{master_id}', name: 'app_affiche_dmfr_susar_post_saisie')]
    public function post_saisie(int $master_id, ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($master_id);
        // $form = $this->createForm(DmfrSusarPostSaisieType::class, $Susar);
        $form = $this->createForm(SusarPostSaisieDmfrType::class, $Susar);
        // $form = $this->createForm(EvalSusarType::class, $Susar, [
        //     'attr' => 'ReadOnly',
        // ]);
        $form->handleRequest($request);


        return $this->render('eval_susar/affiche_dmfr_susar_post_saisie.html.twig', [
            'Susar' => $Susar,
            'form' => $form->createView(),
        ]);
    }
}
