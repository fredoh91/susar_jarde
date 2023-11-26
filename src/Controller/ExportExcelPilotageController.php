<?php

namespace App\Controller;

use App\Entity\Susar;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_SURV_PILOTEVEC")'))]
class ExportExcelPilotageController extends AbstractController
{
    #[Route('/export_excel_pilotage', name: 'app_export_excel_pilotage')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $date = new DateTimeImmutable();
        $now = $date->format('Ymd_His');
        $nomFichierExcel= "Indic_Susar_Jarde_" . $now . ".xlsx";
        $repExport = "./Temp/ExportExcelPilotage/";
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $entityManager = $doctrine->getManager();
        $repo = $entityManager->getRepository(Susar::class);
        $LstSusarsPilotage=$repo->TousSusarPilotage();

        $activeWorksheet->setCellValue('A1', 'idSUSAR');
        $activeWorksheet->setCellValue('B1', 'Date d\'import');
        $activeWorksheet->setCellValue('C1', 'Case Version');
        $activeWorksheet->setCellValue('D1', 'Num_EUDRACT');
        $activeWorksheet->setCellValue('E1', 'Produit');
        $activeWorksheet->setCellValue('F1', 'DCI');
        $activeWorksheet->setCellValue('G1', 'DMM_pole_court');
        $activeWorksheet->setCellValue('H1', 'Mesure/Action');
        $activeWorksheet->setCellValue('I1', 'Commentaire');
        $activeWorksheet->setCellValue('J1', 'Util. eval.');
        $activeWorksheet->setCellValue('K1', 'Date eval.');
        $activeWorksheet->setCellValue('L1', 'Susar évalué');
        $activeWorksheet->setCellValue('M1', 'Pays survenue');
        $activeWorksheet->setCellValue('N1', 'survenue en France');
        // $activeWorksheet->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

        
        $iCpt = 1;
        foreach ($LstSusarsPilotage as $Susar) {
            $iCpt++;
            $activeWorksheet->setCellValue('A' . $iCpt, $Susar["idSUSAR"]);
            $activeWorksheet->setCellValue('B' . $iCpt, $Susar["dateImport"]);
            
            // $activeWorksheet->setCellValue('B' . $iCpt, date('d/m/Y H:i:s', strtotime($Susar["dateImport"])));
            // $activeWorksheet->getStyle('B' . $iCpt)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);

            $activeWorksheet->setCellValue('C' . $iCpt, $Susar["DLPVersion"]);
            $activeWorksheet->setCellValue('D' . $iCpt, $Susar["num_eudract"]);
            $activeWorksheet->setCellValue('E' . $iCpt, $Susar["productName"]);
            $activeWorksheet->setCellValue('F' . $iCpt, $Susar["substanceName"]);
            $activeWorksheet->setCellValue('G' . $iCpt, $Susar["DMM_pole_court"]);
            $activeWorksheet->setCellValue('H' . $iCpt, $Susar["Libelle"]);
            $activeWorksheet->setCellValue('I' . $iCpt, $Susar["Commentaire"]);
            $activeWorksheet->setCellValue('J' . $iCpt, $Susar["utilisateurEvaluation"]);
            $activeWorksheet->setCellValue('K' . $iCpt, $Susar["dateEvaluation"]);
            $activeWorksheet->setCellValue('L' . $iCpt, $Susar["Susar_evalue"]);
            $activeWorksheet->setCellValue('M' . $iCpt, $Susar["pays_survenue"]);
            $activeWorksheet->setCellValue('N' . $iCpt, $Susar["survenue_france"]);
        }
        
        // On met la premier ligne en gris
        for($col = 'A'; $col != 'O'; $col++) {
            $activeWorksheet->getStyle($col . '1')->getFill()
                                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                            ->getStartColor()->setARGB('D6DCE1');
        }
        
        // Ajout du filtre automatique
        $activeWorksheet->setAutoFilter(
            $activeWorksheet->calculateWorksheetDimension()
        );
        
        // On freeze la ligne de titre de colonne
        $activeWorksheet->freezePane('A2');
        
        // On modifie le nom de l'onglet
        $activeWorksheet->setTitle("UneLigne"); 
        
        // On modifie la largeur des colonnes
        foreach ($activeWorksheet->getColumnIterator() as $column) {
            switch($column->getColumnIndex())
            {
                case "E":
                    $activeWorksheet->getColumnDimension('E')->setWidth(80, 'mm');
                    break;
                    case "F":
                        $activeWorksheet->getColumnDimension('F')->setWidth(80, 'mm');
                    break;
                case "I":
                    $activeWorksheet->getColumnDimension('I')->setWidth(80, 'mm');
                    break;
                default:
                    $activeWorksheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            };
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($repExport . $nomFichierExcel);

        return $this->render('export_excel_pilotage/FichierExcelPilotage.html.twig', [
            'controller_name' => 'ExportExcelPilotageController',
            'nomFichierExcel' => $repExport . $nomFichierExcel,
        ]);
    }
}
