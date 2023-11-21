<?php

namespace App\Controller;

use DateTime;
use App\Entity\Susar;
use App\Entity\BilanSusar;
use App\Entity\SearchListeBilanSusar;
use App\Form\SearchListeBilanSusarBaseType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted(new Expression('is_granted("ROLE_DMFR_REF") or is_granted("ROLE_SURV_PILOTEVEC")'))]

class BilanSusarsImportesController extends AbstractController
{   
    #[Route('/bilan_susars_importes', name: 'app_bilan_susars_importes')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {

        $entityManager = $doctrine->getManager();

        $search = new SearchListeBilanSusar;
        $form = $this->createForm(SearchListeBilanSusarBaseType::class, $search);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('Recherche')->isClicked()) {
                // si on a cliqué sur le bouton de recherche
                //   => On rempli la table BilanSusarsImportes avec les données fournis dans les champs de recherche

                $debutStatusDate = $form->get('debutStatusDate')->getData();
                $finStatusDate = $form->get('finStatusDate')->getData();
                $LstSusarImporte = $entityManager->getRepository(Susar::class)->LstSusarImporte_statusdate($debutStatusDate,$finStatusDate);

                $this->createBilanSusar( $LstSusarImporte,  $doctrine,  $em);

            } else if ($form->get('Reset')->isClicked()) {
                // si on a cliqué sur le bouton reset 
                //   => On rempli les champs de recherche avec les valeurs par défaut
                //   => On rempli la table BilanSusarsImportes avec les données fournis dans les champs de recherche

                return $this->redirectToRoute('app_bilan_susars_importes');

            } else {
                dd('je sais pas quoi faire');
            }

        } elseif ($form->isSubmitted() && $form->isValid() == false) {
            // Si on a cliqué sur un des boutons du paginator (le formulaire est alors "isSubmitted()" mais pas "isValid()")
            //  => on ne modifie pas le contenu de la table BilanSusarsImportes

        } else {
            // A l'ouverture de la page, les champs de recherche ont les valeurs par defaut.
            //  => Affichage de tous les imports par defaut :

            $debutStatusDate = DateTime::createFromFormat('m-d-Y', '01-01-2023');
            $finStatusDate = new DateTime("now");

            $LstSusarImporte = $entityManager->getRepository(Susar::class)->LstSusarImporte_statusdate($debutStatusDate,$finStatusDate);

            $this->createBilanSusar( $LstSusarImporte,  $doctrine,  $em);

        }

        $TousBilanSusars = $entityManager->getRepository(BilanSusar::class)->findAll();
        
        $NbBilanSusar = count($TousBilanSusars);

        $BilanSusars = $paginator->paginate(
            $TousBilanSusars, 
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('bilan_susars_importes/BilanSusarsImportes.html.twig', [
            'form' => $form->createView(),
            'NbBilanSusar' => $NbBilanSusar,
            'BilanSusars' => $BilanSusars,
        ]);
    }

    private function createBilanSusar(array $LstSusarImporte, ManagerRegistry $doctrine, EntityManagerInterface $em): void 
    { 
        $entityManager = $doctrine->getManager();
        $repo = $entityManager->getRepository(Susar::class);
        $repo->effaceBilanSusar();

        foreach ($LstSusarImporte as $SusarImporte) {
            $bilanSusar = new BilanSusar;

            $statusDate= $SusarImporte['statusdate'];
            $bilanSusar->setStatusdate($statusDate);
            $Lst=$repo->LstSusarStatusDate($statusDate);
            $bilanSusar->setListeDateImport($Lst["dateImport_eff"]);
            $bilanSusar->setNbTotal($Lst["effectif"]);
            $bilanSusar->setNbNonAiguille($repo->NbSusarAiguilleEvalue($statusDate,'dateAiguillage',''));
            $bilanSusar->setNbAiguille($repo->NbSusarAiguilleEvalue($statusDate,'dateAiguillage','NOT'));
            $bilanSusar->setNbNonEvalue($repo->NbSusarAiguilleEvalue($statusDate,'dateEvaluation',''));
            $bilanSusar->setNbEvalue($repo->NbSusarAiguilleEvalue($statusDate,'dateEvaluation','NOT'));

            $em->persist($bilanSusar);
            $em->flush();
        }
    }
}
