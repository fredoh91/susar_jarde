<?php

namespace App\Controller;

use App\Entity\Susar;
use App\Entity\BilanSusar;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[Security("is_granted('ROLE_DMFR_REF') or is_granted('ROLE_SURV_PILOTEVEC')")]
// #[IsGranted('ROLE_DMFR_REF'),IsGranted('ROLE_SURV_PILOTEVEC')]
#[IsGranted(new Expression('is_granted("ROLE_DMFR_REF") or is_granted("ROLE_SURV_PILOTEVEC")'))]
// #[IsGranted('ROLE_DMFR_REF')]
// #[IsGranted('ROLE_SURV_PILOTEVEC')]
class BilanSusarsImportesController extends AbstractController
{
    #[Route('/bilan_susars_importes', name: 'app_bilan_susars_importes')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        
        $entityManager = $doctrine->getManager();
        // $TousSusars = $entityManager->getRepository(Susar::class)->findAll();
        // $NbSusarImporte = $entityManager->getRepository(Susar::class)->NbSusarImporte();

        // $LstSusarImporte = $entityManager->getRepository(Susar::class)->LstSusarImporte();
        $LstSusarImporte = $entityManager->getRepository(Susar::class)->LstSusarImporte_statusdate();
        $repo = $entityManager->getRepository(Susar::class);
        $repo->effaceBilanSusar();

        // dd($LstSusarImporte);
        $iCpt=0;
        foreach ($LstSusarImporte as $SusarImporte) {
            // dd($LstSusarImporte);

            // $iCpt ++;
            // if($iCpt> 12) {break;}

            $bilanSusar = new BilanSusar;

            // $creationDate= $SusarImporte['creationdate'];
            $statusDate= $SusarImporte['statusdate'];
            $bilanSusar->setStatusdate($statusDate);
            $Lst=$repo->LstSusarStatusDate($statusDate);
            // dump($Lst);
/////////////////// j'en suis la 

            // $bilanSusar->setDateImport($SusarImporte['dateImport']);
            $bilanSusar->setListeDateImport($Lst["dateImport_eff"]);
            $bilanSusar->setNbTotal($Lst["effectif"]);
            $bilanSusar->setNbNonAiguille($repo->NbSusarAiguilleEvalue($statusDate,'dateAiguillage',''));
            $bilanSusar->setNbAiguille($repo->NbSusarAiguilleEvalue($statusDate,'dateAiguillage','NOT'));
            $bilanSusar->setNbNonEvalue($repo->NbSusarAiguilleEvalue($statusDate,'dateEvaluation',''));
            $bilanSusar->setNbEvalue($repo->NbSusarAiguilleEvalue($statusDate,'dateEvaluation','NOT'));
            // $bilanSusar->setNbNonAiguille($repo->NbSusarNonAiguille($creationDate));
            // $bilanSusar->setNbAiguille($repo->NbSusarAiguille($creationDate));
            // $bilanSusar->setNbNonEvalue($repo->NbSusarNonEvalue($creationDate));
            // $bilanSusar->setNbEvalue($repo->NbSusarEvalue($creationDate));

            $em->persist($bilanSusar);
            $em->flush();
        }
        
        $TousBilanSusars = $entityManager->getRepository(BilanSusar::class)->findAll();
        
        $NbBilanSusar = count($TousBilanSusars);

        $BilanSusars = $paginator->paginate(
            $TousBilanSusars, 
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('bilan_susars_importes/BilanSusarsImportes.html.twig', [
            'NbBilanSusar' => $NbBilanSusar,
            // 'form' => $form->createView(),
            'BilanSusars' => $BilanSusars,
        ]);


        // return $this->render('bilan_susars_importes/index.html.twig', [
        //     'controller_name' => 'BilanSusarsImportesController',
        // ]);
    }
}
