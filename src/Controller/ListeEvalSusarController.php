<?php

namespace App\Controller;

use App\Entity\Susar;
use App\Entity\SearchListeEvalSusar;
use App\Form\SearchListeSusarDmmType;
// use App\Form\SearchListeEvalSusarType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[Security("is_granted('ROLE_DMM_EVAL') or is_granted('ROLE_SURV_PILOTEVEC')")]
// #[IsGranted('ROLE_DMM_EVAL')]
// #[IsGranted('ROLE_SURV_PILOTEVEC')]
#[IsGranted(new Expression('is_granted("ROLE_DMM_EVAL") or is_granted("ROLE_SURV_PILOTEVEC")'))]
class ListeEvalSusarController extends AbstractController
{
    #[Route('/liste_eval_susar', name: 'app_liste_eval_susar')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $search = new SearchListeEvalSusar;
        $form = $this->createForm(SearchListeSusarDmmType::class, $search);
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
        } elseif ($form->isSubmitted() && $form->isValid() == false) {
            // Si on a cliqué sur un des boutons du paginator (le formulaire est alors "isSubmitted()" mais pas "isValid()")
            $TousSusars = $entityManager->getRepository(Susar::class)->findBySearchListeEvalSusar($search);
        } else {
            // Affichage de tous les susars par defaut :
            $TousSusars = $entityManager->getRepository(Susar::class)->findAll();
        }
        $NbSusar = count($TousSusars);
        // dump(count($TousSusars));
        $Susars = $paginator->paginate(
            $TousSusars, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            15 // Nombre de résultats par page
        );
        return $this->render('eval_susar/liste_eval_susar.html.twig', [
            'Susars' => $Susars,
            'form' => $form->createView(),
            'typeIntervenantANSM' => 'DMM',
            'NbSusar' => $NbSusar,
        ]);
    }
    #[Route('/liste_eval_susar_type_eu', name: 'app_liste_eval_susar_type_eu')]
    public function liste_eval_susar_type_eu(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $search = new SearchListeEvalSusar;
        $form = $this->createForm(SearchListeSusarDmmType::class, $search);
        $form->handleRequest($request);

        $entityManager = $doctrine->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('Recherche')->isClicked()) {
                // si on a cliqué sur le bouton de recherche 


                $debutStatusDate = $form->getData()['debutStatusDate'];
                $finStatusDate = $form->getData()['finStatusDate'];  

                dd($debutStatusDate);
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
        } elseif ($form->isSubmitted() && $form->isValid() == false) {
            // Si on a cliqué sur un des boutons du paginator (le formulaire est alors "isSubmitted()" mais pas "isValid()")
            $TousSusars = $entityManager->getRepository(Susar::class)->findBySearchListeEvalSusar($search);
        } else {
            // Affichage de tous les susars par defaut :
            $TousSusars = $entityManager->getRepository(Susar::class)->findAll();
        }
        $NbSusar = count($TousSusars);
        // dump(count($TousSusars));
        $Susars = $paginator->paginate(
            $TousSusars, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            15 // Nombre de résultats par page
        );



        return $this->render('eval_susar/liste_eval_susar_type_eu.html.twig', [
            'Susars' => $Susars,
            'form' => $form->createView(),
            'typeIntervenantANSM' => 'DMM',
            'NbSusar' => $NbSusar,
        ]);
    }
}
