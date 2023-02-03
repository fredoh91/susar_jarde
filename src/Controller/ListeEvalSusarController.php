<?php

namespace App\Controller;

use App\Entity\Susar;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Knp\Component\Pager\PaginatorInterface;

class ListeEvalSusarController extends AbstractController
{
    #[Route('/liste_eval_susar', name: 'app_liste_eval_susar')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        $entityManager = $doctrine->getManager();
        $TousSusars = $entityManager->getRepository(Susar::class)->findAll();


        $Susars = $paginator->paginate(
            $TousSusars, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );


        return $this->render('liste_eval_susar/index.html.twig', [
            'Susars' => $Susars,
        ]);
    }
}
