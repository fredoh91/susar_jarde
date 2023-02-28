<?php

namespace App\Controller;

use App\Entity\Susar;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BilanSusarsImportesController extends AbstractController
{
    #[Route('/bilan_susars_importes', name: 'app_bilan_susars_importes')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        
        $entityManager = $doctrine->getManager();
        $TousSusars = $entityManager->getRepository(Susar::class)->findAll();

        $NbSusar = count($TousSusars);
        // dump(count($TousSusars));
        $Susars = $paginator->paginate(
            $TousSusars, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            15 // Nombre de résultats par page
        );



        return $this->render('bilan_susars_importes/index.html.twig', [
            'Susars' => $Susars,
            // 'form' => $form->createView(),
            'NbSusar' => $NbSusar,
        ]);


        // return $this->render('bilan_susars_importes/index.html.twig', [
        //     'controller_name' => 'BilanSusarsImportesController',
        // ]);
    }
}
