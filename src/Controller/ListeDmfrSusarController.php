<?php

namespace App\Controller;

use App\Entity\Susar;
use App\Entity\SearchListeEvalSusar;
use App\Form\SearchListeEvalSusarType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListeDmfrSusarController extends AbstractController
{
    #[Route('/liste_dmfr_susar', name: 'app_liste_dmfr_susar')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $search = new SearchListeEvalSusar;
        $form = $this->createForm(SearchListeEvalSusarType::class, $search);
        $form->handleRequest($request);

        $entityManager = $doctrine->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('recherche')->isClicked()) {
                // si on a cliqué sur le bouton de recherche 
                $TousSusars = $entityManager->getRepository(Susar::class)->findBySearchListeEvalSusar($search);
    
                // dd($TousSusars);

            } else if ($form->get('reset')->isClicked()) {
                // si on a cliqué sur le bouton reset 
                $TousSusars = $entityManager->getRepository(Susar::class)->findAll();
                // $search = new SearchListeEvalSusar;
                // $form = $this->createForm(SearchListeEvalSusarType::class, $search);
                // $form->handleRequest($request);
            } else {
                dd('je sais pas quoi faire');
            }




        } else {
            // Affichage de tous les susars par defaut :
            $TousSusars = $entityManager->getRepository(Susar::class)->findAll();
        }
        // dump(count($TousSusars));
        $Susars = $paginator->paginate(
            $TousSusars, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            15 // Nombre de résultats par page
        );



        return $this->render('eval_susar/liste_eval_susar.html.twig', [
            'Susars' => $Susars,
            'form' => $form->createView(),
            'typeIntervenantANSM' => 'DMFR'
        ]);
    }
}
