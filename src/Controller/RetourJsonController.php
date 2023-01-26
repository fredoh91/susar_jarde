<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Susar;
use Symfony\Component\HttpFoundation\JsonResponse;

class RetourJsonController extends AbstractController
{

    /**
     * test de requete ajax, retour d'une response json
     *
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/retour_json', name: 'app_retour_json')]
    public function retour_json(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $Susar = $entityManager->getRepository(Susar::class)->findAll();
        $Susars = [];
        foreach ($Susar as $Key => $Susar) {
            $Susars[$Key]['Id'] = $Susar->getId();
            $Susars[$Key]['Studytitle'] = $Susar->getStudytitle();
            $Susars[$Key]['NumEudract'] = $Susar->getNumEudract();
            $Susars[$Key]['Indication'] = $Susar->getIndication();
        }
        // return $this->render('retour_json/index.html.twig', [
        //     'controller_name' => 'RetourJsonController',
        //     'Susar' => $Susar,
        // ]);
        return new JsonResponse($Susars);
    }


    /**
     * test de requete ajax, gestion de la response json avec fetch
     *
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/affiche_json', name: 'app_affiche_json')]
    public function affiche_json(ManagerRegistry $doctrine): Response
    {
        // $entityManager = $doctrine->getManager();
        // $Susar = $entityManager->getRepository(Susar::class)->findAll();
        // $Susars = [];
        // foreach ($Susar as $Key => $Susar) {
        //     $Susars[$Key]['Id'] = $Susar->getId();
        //     $Susars[$Key]['Studytitle'] = $Susar->getStudytitle();
        //     $Susars[$Key]['NumEudract'] = $Susar->getNumEudract();
        //     $Susars[$Key]['Indication'] = $Susar->getIndication();
        // }
        return $this->render('retour_json/index.html.twig', [
        ]);


        // return new JsonResponse($Susars);
    }
}
