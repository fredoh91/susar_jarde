<?php

namespace App\Controller;

use DateTime;
use App\Util\Util;
use App\Entity\Susar;
use DateTimeImmutable;
// use App\Form\RqSusarType;
use App\Pemba\RequetesPemba;
use App\Entity\TermeRechAttribDMMpole;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[Security("is_granted('ROLE_DMFR_GEST')")]
#[IsGranted('ROLE_DMFR_GEST')]
class RqSusarController extends AbstractController
{
    #[Route('/RqSusarDate/{creationdate}', name: 'RqSusarDateAffDate')]
    public function RqSusarDateAffDate(string $creationdate, ManagerRegistry $doctrine, Request $request): Response
    {
        $defaultData = ['message' => 'Saisissez une date d\'import'];

        $form = $this->createFormBuilder($defaultData)
        ->add('DateCreation', DateType::class, [
            'widget' => 'single_text',
            'label' => 'date d\'import : ',
            'format' => 'yyyy-MM-dd',
            'input' => 'string',
            'data' => $creationdate,
            ])
        ->getForm();
            $entityManager = $doctrine->getManager();
            $creationdate_dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $creationdate . " 00:00:00" );

            // recherche des susar en fonction de la $creationDate renseignée   \DateTime::createFromFormat('Y-m-d', $creationdate)
            $Susar = $entityManager->getRepository(Susar::class)->findByCreationdate($creationdate_dateTime);
            $NbSusar = count($Susar);
            // dd($Susar);
            return $this->render('import_susar/RqSusarDate.html.twig', [
                'form' => $form->createView(),
                'Susar' => $Susar,
                'NbSusar' => $NbSusar,
            ]);
        return $this->render('import_susar/RqSusarDate.html.twig', [
            'form' => $form->createView(),
            'Susar' => '',
            'NbSusar' => '',
        ]);
    }


    #[Route('/RqSusarDate', name: 'RqSusarDate')]
    public function RqSusarDate(ManagerRegistry $doctrine, Request $request): Response
    {
        $defaultData = ['message' => 'Saisissez une date d\'import'];
        $data = new DateTime("now");
        // $data2 = $data->format('Y-m-d H:i:s');
        $data2 = $data->format('Y-m-d');
        // dd($data2);
        $form = $this->createFormBuilder($defaultData)
        ->add('DateCreation', DateType::class, [
            'widget' => 'single_text',
            'label' => 'date d\'import : ',
            'format' => 'yyyy-MM-dd',
            'input' => 'string',
            'data' => $data2,
            ])
        ->add('Recherche', SubmitType::class, [
            'label' => 'Recherche et import',
            ])
        ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $creationdate = $form->getData()['DateCreation'];
            $importTypeSusarEu = $this->getParameter('IMPORT_TYPE_SUSAR_EU');
            $entityManager = $doctrine->getManager();

            $Lst_therapieGen = $entityManager->getRepository(TermeRechAttribDMMpole::class)->TermeRechByType('NumEUDRA_CT');
            $lst_NumEUDRA_CT = $this->FormatSQL_IN($Lst_therapieGen);

            $Lst_therapieGen = $entityManager->getRepository(TermeRechAttribDMMpole::class)->TermeRechByType('Produit');
            $lst_Produit = $this->FormatSQL_IN($Lst_therapieGen);

            $RqPemba = new RequetesPemba($doctrine);
            
            $cas_FrDC_FrPronVit = $RqPemba->donneListeEC_FrDC_FrPronVit($creationdate);
            $cas_TherapieGenique = $RqPemba->donneListeEC_TherapieGenique($creationdate, $lst_NumEUDRA_CT, $lst_Produit);

            // creation des entités SUSAR a partir du résultat des requêtes 
            Util::CreeSUSAR($doctrine, $cas_FrDC_FrPronVit,"FR_DC_ProVit", $importTypeSusarEu);
            Util::CreeSUSAR($doctrine, $cas_TherapieGenique,"TherapGen", $importTypeSusarEu);
            $creationdate_dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $creationdate . " 00:00:00" );
            // recherche des susar en fonction de la $creationDate renseignée   \DateTime::createFromFormat('Y-m-d', $creationdate)
            $Susar = $entityManager->getRepository(Susar::class)->findByCreationdate($creationdate_dateTime);
            $NbSusar = count($Susar);
            return $this->render('import_susar/RqSusarDate.html.twig', [
                'form' => $form->createView(),
                'Susar' => $Susar,
                'NbSusar' => $NbSusar,
            ]);
        }
        return $this->render('import_susar/RqSusarDate.html.twig', [
            'form' => $form->createView(),
            'Susar' => '',
            'NbSusar' => '',
        ]);
    }
 
    /**
     * Construit une liste de "TermeRech" séparés par des virgules pour faire une requête avec un WHERE ... IN ('jhj','hjhj','hjhjh','jkjl')
     *
     * @param array $lstEntree
     * @return void
     */
    private function FormatSQL_IN (array $lstEntree) 
    {
        foreach ($lstEntree as $ter) {
            if (isset($lst) ) {
                $lst .= ",'".$ter->getTermeRech()."'";
            } else { 
                $lst = "'".$ter->getTermeRech()."'"; 
            }
        }
        return $lst;
    }    

}
