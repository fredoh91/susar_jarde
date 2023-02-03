<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Susar;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Glossaire;

class RetourJsonController extends AbstractController
{

    /**
     * test de requete ajax, retour d'une response json
     *
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/retour_json/{indication}', name: 'app_retour_json')]
    public function retour_json(string $indication, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        // $Susar = $entityManager->getRepository(Susar::class)->findAll();
        // $Glossaire = $entityManager->getRepository(Glossaire::class)->findFiveFirst();
        $Glossaire = $entityManager->getRepository(Glossaire::class)->findByIndication($indication);
        $Glossaires = [];
        foreach ($Glossaire as $Key => $Glossaire) {
            $Glossaires[$Key]['Id'] = $Glossaire->getId();
            $Glossaires[$Key]['itemGlossaire'] = $Glossaire->getItemGlossaire();
            $Glossaires[$Key]['pole_court'] = $Glossaire->getPoleCourt();
            $Glossaires[$Key]['pole_long'] = $Glossaire->getPoleLong();
        }
        // return $this->render('retour_json/test.html.twig', [
        //     'controller_name' => 'RetourJsonController',
        //     'Glossaires' => $Glossaires,
        // ]);
        return new JsonResponse($Glossaires);
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

        return $this->render('retour_json/index.html.twig', [
        ]);

    }
}
