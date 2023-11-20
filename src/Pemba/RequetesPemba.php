<?php

namespace App\Pemba;

use Doctrine\Persistence\ManagerRegistry;

class RequetesPemba
{
    private $em;
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        // $this->dateCreation = $dateCreation;
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager('pemba');
    }
    /**
     * Retourne un array pour remplir les différentes table, lors de l'import depuis la BNPV
     * Retourne les SUSARs : France-Décès et France-Pronostic vital
     *
     * @param string $dateCreation
     * @return array
     */
    public function donneListeEC_FrDC_FrPronVit(string $dateStatus): array
    {

        $sql = "SELECT DISTINCT "

            . "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion, mv.creationdate, mv.statusdate, "
            // . "st.studytitle, st.sponsorstudynumb, "
            // . "sr.studyname num_eudract, sr.studyregistrationcountry pays_etude, "
            . "id.worldwideuniquecaseidentificationnumber, "
            . "ci.iscaseserious, ci.seriousnesscriteria, ci.receivedate, "
            . "mo.receiptdate, "
            . "pa.patientsex, pa.patientonsetage, pa.patientonsetageunitlabel, pa.patientagegroup, "
            . "ps.reportercountry pays_survenue, "
            . "na.narrativeincludeclinical, "
            . "cs.casesummarylanguage, cs.casesummary "
            . "FROM master_versions mv "
            . "INNER JOIN (SELECT master_id, MAX(receiptdate) AS receiptdate FROM bi_mostrecentinformation GROUP BY master_id) AS mo ON mv.id = mo.master_id "
            . "INNER JOIN bi_caseinfo ci ON mv.id = ci.master_id "
            . "INNER JOIN bi_identifiers id ON mv.id = id.master_id "
            . "INNER JOIN bi_patientinformations pa ON mv.id = pa.master_id "
            . "INNER JOIN bi_primarysource ps ON mv.id = ps.master_id "
            . "LEFT JOIN bi_narrative na ON mv.id = na.master_id "
            . "LEFT JOIN bi_case_summary cs ON mv.id = cs.master_id "
            // . "LEFT JOIN bi_study st ON mv.id = st.master_id "
            // . "LEFT JOIN bi_study_registration sr ON mv.id = sr.master_id "
            . "WHERE 1 = 1 "
            . "AND specificcaseid LIKE 'EC%' "
            // . "AND mv.StatusDate = '" . $dateStatus . "' "
            // . "AND mv.StatusDate = '" . $dateStatus . "' "
            . "AND mv.StatusDate >= '" . $dateStatus . "' AND mv.StatusDate < '". date('Y-m-d', strtotime($dateStatus. ' + 1 day')) . "' "
            // . "AND mv.Deleted = 0 "
            . "AND ci.casenullification <> 'Nullification' "
            . "AND ps.primarysourceforregulatorypurposes LIKE 'Yes' "
            . "AND (ci.seriousnesscriteria LIKE '%Death%' OR ci.seriousnesscriteria LIKE '%Life Threatening%') "
            . "AND ps.reportercountry = 'FR' "
            . "ORDER BY mv.id;";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();

        return $stmt_2;
    }

    /**
     * Retourne un array pour remplir les différentes table, lors de l'import depuis la BNPV
     * Retourne les SUSARs : Thérapie génique, selon une liste de codes produit ou de NumEUDRA_CT
     *
     * @param string $dateCreation
     * @param string $lst_NumEUDRA_CT
     * @param string $lst_Produit
     * @return array
     */
    public function donneListeEC_TherapieGenique(string $dateStatus, string $lst_NumEUDRA_CT, string $lst_Produit): array
    {

        $sql = "SELECT DISTINCT "
            . "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion, mv.creationdate, mv.statusdate, "
            // . "st.studytitle, st.sponsorstudynumb, "
            // . "sr.studyname num_eudract, sr.studyregistrationcountry pays_etude, "
            . "id.worldwideuniquecaseidentificationnumber, "
            . "ci.iscaseserious, ci.seriousnesscriteria, ci.receivedate, "
            . "mo.receiptdate, "
            . "pa.patientsex, pa.patientonsetage, pa.patientonsetageunitlabel, pa.patientagegroup, "
            . "ps.reportercountry pays_survenue, "
            . "na.narrativeincludeclinical, "
            . "cs.casesummarylanguage, cs.casesummary "
            . "FROM master_versions mv "
            . "LEFT JOIN bi_study st ON mv.id = st.master_id "
            . "LEFT JOIN bi_study_registration sr ON mv.id = sr.master_id "
            . "INNER JOIN bi_identifiers id ON mv.id = id.master_id "
            . "INNER JOIN bi_caseinfo ci ON mv.id = ci.master_id "
            . "INNER JOIN (SELECT master_id, MAX(receiptdate) AS receiptdate FROM bi_mostrecentinformation GROUP BY master_id) AS mo ON mv.id = mo.master_id "
            . "INNER JOIN bi_patientinformations pa ON mv.id = pa.master_id "
            . "INNER JOIN bi_primarysource ps ON mv.id = ps.master_id "
            . "LEFT JOIN bi_narrative na ON mv.id = na.master_id "
            . "LEFT JOIN bi_case_summary cs ON mv.id = cs.master_id "
            . "WHERE 1 = 1 "
            . "AND specificcaseid LIKE 'EC%' "
            . "AND mv.StatusDate = '" . $dateStatus . "' "
            // . "AND mv.Deleted = 0 "
            . "AND ci.casenullification <> 'Nullification' "
            . "AND ps.primarysourceforregulatorypurposes LIKE 'Yes' "
            . "AND ( sr.studyname IN (" . $lst_NumEUDRA_CT . ") "
            . "   OR mv.id IN (SELECT DISTINCT mv.id as id_prod "
            .                           " FROM master_versions mv "
            .                           " INNER JOIN bi_product pr ON mv.id = pr.master_id "
            .                           " LEFT JOIN bi_product_substance su ON pr.master_id = su.master_id AND pr.NBBlock = su.NBBlock "
            .                           " WHERE 1 = 1 "
            .                           " AND specificcaseid LIKE 'EC%' AND su.substancename IN  (" . $lst_Produit . ") "
            .                           " AND mv.Deleted = 0) "
            . "    ) "
            . "ORDER BY mv.id;";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();

        return $stmt_2;
    }
    /**
     * Retourne la liste des indications pour stockage dans les tables Susar et Indications, lors de l'import depuis la BNPV
     *
     * @param integer $master_id
     * @return array
     */
    public function donneListeIndicationMedSuspect_array(int $master_id): array
    {
        $sql = "SELECT DISTINCT "
            . "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion, "
            . "TRIM(REPLACE(pr.productname, '\n', '')) productname, "
            . "id.productindication, id.codeproductindication "
            . "FROM master_versions mv "
            . "INNER JOIN bi_product pr ON mv.id = pr.master_id "
            . "LEFT JOIN bi_product_indication id ON pr.master_id = id.master_id AND pr.NBBlock = id.NBBlock "
            . "WHERE 1 = 1 "
            . "AND specificcaseid LIKE 'EC%' "
            . "AND mv.id = " . $master_id . " "
            . "AND pr.productcharacterization = 'Suspect' "
            . "ORDER BY id.productindication; ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();
        return $stmt_2;
    }

    /**
     * Retourne un tableau avec les données de l'étude (studytitle, sponsorstudynumb, num_eudract, pays_etude) pour la création d'une ligne dans la table Susar
     *
     * @param integer $master_id
     * @return array
     */
    public function donneDonneesEtude(int $master_id): array
    {
        $sql = "SELECT DISTINCT "
            . "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion,  "
            . "st.studytitle, st.sponsorstudynumb,  "
            . "sr.studyname num_eudract, sr.studyregistrationcountry pays_etude  "
            . "FROM master_versions mv  "
            . "LEFT JOIN bi_study st ON mv.id = st.master_id  "
            . "LEFT JOIN bi_study_registration sr ON mv.id = sr.master_id   "
            . "WHERE 1 = 1  "
            . "AND specificcaseid LIKE 'EC%'  "
            . "AND mv.id = " . $master_id . " "
            . "AND sr.studyregistrationcountry = 'EU'  "
            . "AND mv.Deleted = 0;  ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();

        if (count($stmt_2) > 0) {
            foreach ($stmt_2 as $ter) {

                if (isset($studytitle)) {
                    $studytitle .= "," . $ter['studytitle'];
                } else {
                    $studytitle = $ter['studytitle'];
                }

                if (isset($sponsorstudynumb)) {
                    $sponsorstudynumb .= "," . $ter['sponsorstudynumb'];
                } else {
                    $sponsorstudynumb = $ter['sponsorstudynumb'];
                }

                if (isset($num_eudract)) {
                    $num_eudract .= "," . $ter['num_eudract'];
                } else {
                    $num_eudract = $ter['num_eudract'];
                }

                if (isset($pays_etude)) {
                    $pays_etude .= "," . $ter['pays_etude'];
                } else {
                    $pays_etude = $ter['pays_etude'];
                }

                $ret['studytitle'] = $studytitle;
                $ret['sponsorstudynumb'] = $sponsorstudynumb;
                $ret['num_eudract'] = $num_eudract;
                $ret['pays_etude'] = $pays_etude;

                return $ret;
            }
        } else {
            // la requete n'a rien retourné, on retente sans la clause : AND sr.studyregistrationcountry = 'EU'
            $sql = "SELECT DISTINCT "
                        . "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion,  "
                        . "st.studytitle, st.sponsorstudynumb,  "
                        . "sr.studyname num_eudract, sr.studyregistrationcountry pays_etude  "
                        . "FROM master_versions mv  "
                        . "LEFT JOIN bi_study st ON mv.id = st.master_id  "
                        . "LEFT JOIN bi_study_registration sr ON mv.id = sr.master_id   "
                        . "WHERE 1 = 1  "
                        . "AND specificcaseid LIKE 'EC%'  "
                        . "AND mv.id = " . $master_id . " "
                        . "AND mv.Deleted = 0;  ";

            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt_2 = $stmt->execute()->fetchAll();

            if (count($stmt_2) > 0) {
                foreach ($stmt_2 as $ter) {

                    if (isset($studytitle)) {
                        $studytitle .= "," . $ter['studytitle'];
                    } else {
                        $studytitle = $ter['studytitle'];
                    }

                    if (isset($sponsorstudynumb)) {
                        $sponsorstudynumb .= "," . $ter['sponsorstudynumb'];
                    } else {
                        $sponsorstudynumb = $ter['sponsorstudynumb'];
                    }

                    if (isset($num_eudract)) {
                        $num_eudract .= "," . $ter['num_eudract'];
                    } else {
                        $num_eudract = $ter['num_eudract'];
                    }

                    if (isset($pays_etude)) {
                        $pays_etude .= "," . $ter['pays_etude'];
                    } else {
                        $pays_etude = $ter['pays_etude'];
                    }

                    $ret['studytitle'] = $studytitle;
                    $ret['sponsorstudynumb'] = $sponsorstudynumb;
                    $ret['num_eudract'] = $num_eudract;
                    $ret['pays_etude'] = $pays_etude;

                    return $ret;
                }
            } else {
                // la requete n'a rien retourné
                return [];
            }

            // return [];
        }

    }

    /**
     * Ancienne methode utilisée pour remplir l'indication fr dans la table Susar, lors de l'import depuis la BNPV
     *
     * @param integer $master_id
     * @return string
     */
    public function donneListeIndication(int $master_id): string
    {

        $sql = "SELECT DISTINCT "
            . "id.productindication "
            . "FROM master_versions mv "
            . "INNER JOIN bi_product pr ON mv.id = pr.master_id "
            . "LEFT JOIN bi_product_indication id ON pr.master_id = id.master_id AND pr.NBBlock = id.NBBlock "
            . "WHERE 1 = 1 "
            . "AND specificcaseid LIKE 'EC%' "
            . "AND mv.id = " . $master_id . " "
            . "AND pr.productcharacterization = 'Suspect' "
            . "ORDER BY id.productindication; ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();

        if (is_null($stmt_2[0]['productindication'])) {
            return "";
        } else {
            foreach ($stmt_2[0] as $ter) {

                if (isset($lst)) {
                    $lst .= "," . $ter;
                } else {
                    $lst = $ter;
                }
            }
            return $lst;
        };
    }



    /**
     * Dans la BNPV les critères de gravité sont stockés avec des doublons et séparé par deux tildes ~~
     * cette methode enlève les doublons et met un saut de ligne HTMH comme séparateur entre deux critères
     *
     * @param string $critGrav_entree : chaine contenant les criteres de gravité séparés par deux tildes ~~
     * @return string chaine contenant les critères de gravité sans doublon et séparé par un <BR>
     */
    public function donneCriteresGraviteSansDoublon(string $critGrav_entree): string
    {
        $critGrav="";
        // dump($critGrav_entree);
        $tabCritGrav= explode("~~", $critGrav_entree);
        foreach ($tabCritGrav as $critere) {
            if(strpos($critGrav, $critere) === false) {
                $critGrav .= $critere . "<BR>";
            }
        }
        // dump($critGrav);
        return $critGrav;
    }


    /**
     * Ancienne méthode utilisée pour récupérer les codes indications pour ensuite retrouver les indications en anglais et les stocker dans la table Susar, lors de l'import depuis la BNPV
     *
     * @param integer $master_id
     * @return array
     */
    public function donneListeCodeIndication(int $master_id): array
    {
        $sql = "SELECT DISTINCT "
            . "id.codeproductindication "
            . "FROM master_versions mv "
            . "INNER JOIN bi_product pr ON mv.id = pr.master_id "
            . "LEFT JOIN bi_product_indication id ON pr.master_id = id.master_id AND pr.NBBlock = id.NBBlock "
            . "WHERE 1 = 1 "
            . "AND specificcaseid LIKE 'EC%' "
            . "AND mv.id = " . $master_id . " "
            . "AND pr.productcharacterization = 'Suspect' "
            . "ORDER BY id.productindication; ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();

        $lst = [];
        if (is_null($stmt_2[0]['codeproductindication'])) {
            // return "";
            return [];
        } else {
            foreach ($stmt_2[0] as $ter) {
                $lst[] = $ter;
            }
            return $lst;
        };
    }

    /**
     * Retourne un tableau de médicament, utilisé pour remplir la table Médicaments, lors de l'import depuis la BNPV
     *
     * @param integer $master_id
     * @param string $prodCharact
     * @return array
     */
    public function donneListeMedicament(int $master_id, string $prodCharact): array
    {

        $sql = "SELECT DISTINCT "
            . "mv.id, mv.caseid, mv.specificcaseid, mv.DLPVersion, "
            . "pr.productcharacterization, TRIM(REPLACE(pr.productname, '\n', '')) productname, pr.NBBlock, su.substancename "
            . "FROM master_versions mv "
            . "INNER JOIN bi_product pr ON mv.id = pr.master_id "
            . "LEFT JOIN bi_product_substance su ON pr.master_id = su.master_id AND pr.NBBlock = su.NBBlock "
            . "WHERE 1 = 1 "
            . "AND specificcaseid LIKE 'EC%' "
            . "AND mv.id = " . $master_id . " ";

        if ($prodCharact === "Tout") {
        } elseif ($prodCharact === "Suspect") {
            $sql .= "AND pr.productcharacterization = 'Suspect' ";
        } elseif ($prodCharact === "Concomitant") {
            $sql .=  "AND pr.productcharacterization = 'Concomitant' ";
        } else {
        }
        $sql .=  "AND mv.Deleted = 0; ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();

        if (is_null($stmt_2[0])) {
            return "";
        } else {
            foreach ($stmt_2 as $medicament) {
                // dump($medicament);
                if (isset($lstproductname)) {
                    $lstproductname .= "," . $medicament['productname'];
                } else {
                    $lstproductname = $medicament['productname'];
                }
                if (isset($lstsubstancename)) {
                    $lstsubstancename .= "," . $medicament['substancename'];
                } else {
                    $lstsubstancename = $medicament['substancename'];
                }
            }

            $med = ['productname' => $lstproductname, 'substancename' => $lstsubstancename];
            return $med;
        };
    }
}
