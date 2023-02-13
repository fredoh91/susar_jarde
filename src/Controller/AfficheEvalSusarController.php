<?php

namespace App\Controller;

use App\Entity\Susar;
use App\Form\EvalSusarType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AfficheEvalSusarController extends AbstractController
{
    #[Route('/affiche_eval_susar/{master_id}', name: 'app_affiche_eval_susar')]
    public function index(int $master_id, ManagerRegistry $doctrine, Request $request, EntityManagerInterface $em): Response
    {
        $entityManager = $doctrine->getManager();
        $Susar = $entityManager->getRepository(Susar::class)->findSusarByMasterId($master_id);
        $form = $this->createForm(EvalSusarType::class, $Susar);
        $form->handleRequest($request);



        return $this->render('eval_susar/affiche_eval_susar.html.twig', [
            'Susar' => $Susar,
            'form' => $form->createView(),
        ]);
    }
}
