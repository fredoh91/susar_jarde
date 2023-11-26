<?php

namespace App\Repository;

use DateTime;
// use App\Entity\IntervenantsANSM;
use DateInterval;
use App\Entity\Susar;
use DateTimeInterface;
use App\Entity\SearchListeEvalSusar;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Susar>
 *
 * @method Susar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Susar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Susar[]    findAll()
 * @method Susar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SusarRepository extends ServiceEntityRepository
{    
    // private $connexion;
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Susar::class);
        $this->registry = $registry;
    }

    public function save(Susar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Susar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * permet de savoir si le master_id en entrée est déjà existant dans la table SUSAR, pour éviter de créer des doublons
     *
     * @param [int] $value : master_id recherché dans la table SUSAR
     * @return boolean : false si le master_id existe déjà, true si il n'existe pas
     */
    public function EstCe_SUSAR_unique($value): bool
    {
        // dump($value);
        $query = $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->andWhere('s.master_id = :val')
            ->setParameter('val', $value)
            ->getQuery();

        // dump($value . " : " . $query->getSQL());

        $test = $query->getSingleScalarResult();

        if ($test > 0) {
            // if ($test > 1 )  {
            //     dump($test . " : false");
            //     return false;
            // } else {
            //     dump($test . " : false");
            //     return false;
            // }
            return false;
        } else {
            // dump($test . " : true");
            return true;
        }
    }



    /**
     * permet de savoir si le couple specificcaseid / DLPVersion en entrée est déjà existant dans la table SUSAR, pour éviter de créer des doublons
     *
     * @param [string] $specificcaseid : specificcaseid recherché dans la table SUSAR
     * @param [int] $DLPVersion : DLPVersion recherché dans la table SUSAR
     * @return boolean : false si le couple specificcaseid / DLPVersion existe déjà, true si il n'existe pas
     */
    public function EstCe_SUSAR_unique_specificcaseid_DLPVersion(string $specificcaseid,int $DLPVersion): bool
    {
        // dump($value);
        $query = $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->andWhere('s.specificcaseid = :sci')
            ->andWhere('s.DLPVersion = :FU')
            ->setParameter('sci', $specificcaseid)
            ->setParameter('FU', $DLPVersion)
            ->getQuery();

        // dump($specificcaseid . " / " . $DLPVersion . " : " . $query->getSQL());

        $test = $query->getSingleScalarResult();

        if ($test > 0) {
            // if ($test > 1 )  {
            //     dump($test . " : false");
            //     return false;
            // } else {
            //     dump($test . " : false");
            //     return false;
            // }
            return false;
        } else {
            // dump($test . " : true");
            return true;
        }
    }


    /**
     * Permet de retourner un tableau de susar selon la creationdate
     *
     * @param DateTimeInterface $creationdate
     * @return array Susar[] Returns an array of Susar objects
     */
    public function findByCreationdate(DateTimeInterface $creationdate): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.creationdate = :val')
            ->setParameter('val', $creationdate)
            ->orderBy('s.master_id', 'ASC')
            ->getQuery()
            ->getResult();
    }



    /**
     * Permet de retourner un tableau de susar selon la statusdate
     *
     * @param DateTimeInterface $statusdate
     * @return array Susar[] Returns an array of Susar objects
     */
    public function findByStatusdate(DateTimeInterface $statusdate): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.statusdate = :val')
            ->setParameter('val', $statusdate)
            ->orderBy('s.master_id', 'ASC')
            ->getQuery()
            ->getResult();
    }



    /**
     * Permet de retourner le master_id suivant par rapport au master_id en entrée
     *
     * @param DateTimeInterface $creationdate
     * @param integer $master_id : entrée
     * @return integer $master_id : qui suit celui en entrée. ou 0 si celui en entrée est le dernier de la série
     */
    public function findNextMasterIdByCreationdate(DateTimeInterface $creationdate, int $master_id): int
    {
        $SerieSusar = $this->findByCreationdate($creationdate);
        $iCpt = 0;
        $iCpt_master_id = -1;

        foreach ($SerieSusar as $Susar) {
            $iCpt++;

            // dump("--".$Susar->getMasterId() . " icpt : " . $iCpt . " icpt + 1 " .($iCpt_master_id + 1));

            if (($iCpt_master_id + 1) === $iCpt) {
                $next_master_id = $Susar->getMasterId();
                // dump("NMI : ".$next_master_id);
                // dd($iCpt);
            }
            if ($Susar->getMasterId() === $master_id) {
                $iCpt_master_id = $iCpt;
                // dump("cpt_master_id : " . $iCpt_master_id);
            }
        }
        if ($iCpt_master_id === $iCpt) {
            return 0;
        }

        if (isset($next_master_id)) {
            return $next_master_id;
        }
        return 0;
    }

    /**
     * Permet de retourner le master_id suivant par rapport au master_id en entrée
     *
     * @param DateTimeInterface $statusdate
     * @param integer $master_id : entrée
     * @return integer $master_id : qui suit celui en entrée. ou 0 si celui en entrée est le dernier de la série
     */
    public function findNextMasterIdByStatusdate(DateTimeInterface $statusdate, int $master_id): int
    {
        $SerieSusar = $this->findByStatusdate($statusdate);
        $iCpt = 0;
        $iCpt_master_id = -1;

        foreach ($SerieSusar as $Susar) {
            $iCpt++;

            // dump("--".$Susar->getMasterId() . " icpt : " . $iCpt . " icpt + 1 " .($iCpt_master_id + 1));

            if (($iCpt_master_id + 1) === $iCpt) {
                $next_master_id = $Susar->getMasterId();
                // dump("NMI : ".$next_master_id);
                // dd($iCpt);
            }
            if ($Susar->getMasterId() === $master_id) {
                $iCpt_master_id = $iCpt;
                // dump("cpt_master_id : " . $iCpt_master_id);
            }
        }
        if ($iCpt_master_id === $iCpt) {
            return 0;
        }

        if (isset($next_master_id)) {
            return $next_master_id;
        }
        return 0;
    }


    public function findSusarByMasterId(int $master_id): ?Susar
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.master_id = :val')
            ->setParameter('val', $master_id)
            ->getQuery()
            ->getOneOrNullResult();
    }
    /**
     * retourne la liste des SUSARs recherchés par un formulaire du type SearchListeEvalSusarType
     *
     * @param SearchListeEvalSusar $search
     * @return Susar|null
     */
    public function findBySearchListeEvalSusar(SearchListeEvalSusar $search): ?array
    {

        $query = $this->createQueryBuilder('s');

        if ($search->getSpecificcaseid()) {
            $query = $query
                ->andWhere('s.specificcaseid = :sci')
                ->setParameter('sci', $search->getSpecificcaseid());
        }

        if ($search->getMasterId()) {
            $query = $query
                ->andWhere('s.master_id = :mi')
                ->setParameter('mi', $search->getMasterId());
        }

        if ($search->getDLPVersion()) {
            $query = $query
                ->andWhere('s.DLPVersion = :dv')
                ->setParameter('dv', $search->getDLPVersion());
        }

        if ($search->getCaseid()) {
            $query = $query
                ->andWhere('s.caseid = :ci')
                ->setParameter('ci', $search->getCaseid());
        }

        if ($search->getNumEudract()) {
            $query = $query
                ->andWhere('s.num_eudract = :ne')
                ->setParameter('ne', $search->getNumEudract());
        }

        if ($search->getWorldWideId()) {
            $query = $query
                ->andWhere('s.worldWide_id LIKE :wwi')
                ->setParameter('wwi', '%' . $search->getWorldWideId() . '%');
        }

        if ($search->getSponsorstudynumb()) {
            $query = $query
                ->andWhere('s.sponsorstudynumb = :ssn')
                ->setParameter('ssn', $search->getSponsorstudynumb());
        }

        if ($search->getStudytitle()) {
            $query = $query
                ->andWhere('s.studytitle LIKE :st')
                ->setParameter('st', '%' . $search->getStudytitle() . '%');
        }

        if ($search->getProductName()) {
            $query = $query
                ->andWhere('s.productName LIKE :pn')
                ->setParameter('pn', '%' . $search->getProductName() . '%');
        }

        if ($search->getSubstanceName()) {
            $query = $query
                ->andWhere('s.substanceName LIKE :sn')
                ->setParameter('sn', '%' . $search->getSubstanceName() . '%');
        }

        if ($search->getIndication()) {
            $query = $query
                ->andWhere('s.indication LIKE :if')
                ->setParameter('if', '%' . $search->getIndication() . '%');
        }

        if ($search->getIndicationEng()) {
            $query = $query
                ->andWhere('s.indication_eng LIKE :ie')
                ->setParameter('ie', '%' . $search->getIndicationEng() . '%');
        }

        // dd($search->getIntervenantANSM()->getDMMPoleCourt());
        if ($search->getIntervenantANSM()) {
            $query = $query
                ->leftJoin('s.intervenantANSM', 'iANSM')
                ->andWhere('iANSM.DMM_pole_court LIKE :ia')
                ->setParameter('ia', '%' . $search->getIntervenantANSM()->getDMMPoleCourt() . '%');
        }

        // dd($search->getMesureAction()->getLibelle());
        if ($search->getMesureAction()) {
            $query = $query
                ->leftJoin('s.MesureAction', 'ma')
                ->andWhere('ma.Libelle LIKE :ia')
                ->setParameter('ia', '%' . $search->getMesureAction()->getLibelle() . '%');
        }

        // if ($search->getDebutCreationDate()) {
        //     $query = $query
        //         ->andWhere('s.creationdate >= :dcd')
        //         ->setParameter('dcd', $search->getDebutCreationDate());
        // }

        // if ($search->getFinCreationDate()) {
        //     $query = $query
        //         ->andWhere('s.creationdate <= :fcd')
        //         ->setParameter('fcd', $search->getFinCreationDate());
        // }

        if ($search->getDebutStatusDate()) {
            $query = $query
                ->andWhere('s.statusdate >= :dsd')
                ->setParameter('dsd', $search->getDebutStatusDate());
        }

        if ($search->getFinStatusDate()) {
            $query = $query
                ->andWhere('s.statusdate <= :fsd')
                ->setParameter('fsd', $search->getFinStatusDate());
        }

        if ($search->getDebutDateImport()) {
            $query = $query
                ->andWhere('s.dateImport >= :ddi')
                ->setParameter('ddi', $search->getDebutDateImport());
        }

        if ($search->getFinDateImport()) {
            $query = $query
                ->andWhere('s.dateImport <= :fdi')
                ->setParameter('fdi', $search->getFinDateImport()->modify('+1 day'));
        }

        if ($search->getDebutDateAiguillage()) {
            $query = $query
                ->andWhere('s.dateAiguillage >= :dda')
                ->setParameter('dda', $search->getDebutDateAiguillage());
        }

        if ($search->getFinDateAiguillage()) {
            $query = $query
                ->andWhere('s.dateAiguillage <= :fda')
                ->setParameter('fda', $search->getFinDateAiguillage()->modify('+1 day'));
        }

        if ($search->getDebutDateEvaluation()) {
            $query = $query
                ->andWhere('s.dateEvaluation >= :dde')
                ->setParameter('dde', $search->getDebutDateEvaluation());
        }

        if ($search->getFinDateEvaluation()) {
            $query = $query
                ->andWhere('s.dateEvaluation <= :fde')
                ->setParameter('fde', $search->getFinDateEvaluation()->modify('+1 day'));
        }

        if ($search->getEvalue()) {
            if ($search->getEvalue() === 'Non') {
                $query = $query
                    ->andWhere('s.dateEvaluation IS NULL');
            } elseif ($search->getEvalue() === 'Oui') {
                $query = $query
                    ->andWhere('s.dateEvaluation IS NOT NULL');
            } else {}
        }

        if ($search->getAiguille()) {
            if ($search->getAiguille() === 'Non') {
                $query = $query
                    ->andWhere('s.intervenantANSM IS NULL');
            } elseif ($search->getAiguille() === 'Oui') {
                $query = $query
                    ->andWhere('s.intervenantANSM IS NOT NULL');
            } else {}
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    /**
     * retourne les 5 premiers Susar, pour tester
     *
     * @return array Susar[] Returns an array of Susar objects
     */
    public function findFiveFirst(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    /**
     * retourne le nombre de susar import pour la creationdate envoyée en parametre
     *
     * @return array
     */
    public function LstSusarImporte(): array
    {
        return $this->createQueryBuilder('s')
                    ->select('count(s.id), s.creationdate, s.dateImport')
                    ->groupBy('s.creationdate')
                    ->orderBy('s.creationdate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }


    /**
     * retourne le nombre de susar import pour la statusdate envoyée en parametre
     *
     * @return array
     */
    public function LstSusarImporte_statusdate_v1(): array
    {
        return $this->createQueryBuilder('s')
                    ->select('count(s.id), s.statusdate')
                    ->groupBy('s.statusdate')
                    ->orderBy('s.statusdate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }


    /**
     * retourne le nombre de susar import pour la statusdate envoyée en parametre
     *
     * @param DateTime $debutStatusDate
     * @param DateTime $finStatusDate
     * @return array
     */

    public function LstSusarImporte_statusdate(DateTime $debutStatusDate , DateTime $finStatusDate ): array
    {
        return $this->createQueryBuilder('s')
                    ->select('count(s.id), s.statusdate')
                    ->andWhere('s.statusdate >= :date_start')
                    ->andWhere('s.statusdate <= :date_end')
                    ->setParameter('date_start', $debutStatusDate)
                    ->setParameter('date_end',   $finStatusDate)
                    ->groupBy('s.statusdate')
                    ->orderBy('s.statusdate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

                        /*************************************/
                        /**    Bilan des susars importés    **/
                        /*************************************/

    /**
     * retourne le nombre de susar import pour la creationdate envoyé en parametre
     *
     * @return Int
     */
    public function NbSusarImporte(): Int
    {
        return $this->createQueryBuilder('s')
                    ->select('count(s.id)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    /**
     * retourne le nombre de susar importés AIGUILLÉS et ÉVALUÉS pour la creationdate envoyé en parametre
     *
     * @return Int
     */
    public function NbSusarAiguilleEvalue(DateTime $creationdate, string $nomColonne, string $nullNotNull): Int
    {
        return $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->andWhere('s.' . $nomColonne . ' IS ' . $nullNotNull . ' NULL')
            ->andWhere('s.creationdate = :val')
            ->setParameter('val', $creationdate)
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function effaceBilanSusar(): void
    {

        $sql = "START TRANSACTION;";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;";
        $sql .= "TRUNCATE bilansusar;";
        $sql .= "SET FOREIGN_KEY_CHECKS=1;";
        $sql .= "COMMIT;";

        $this->registry->getConnection()->query($sql);

    }

    /**
     * Retourne un array avec les differentes date d'import et les effectifs par date d'import pour une statusdate 
     *
     * @param DateTime $statusdate
     * @return Array
     */
    public function LstSusarStatusDate(DateTime $statusdate): Array
    {
        $em = $this->getEntityManager();

        $sql = "SELECT COUNT(s.id) AS effectif, " .
                "DATE_FORMAT(s.dateImport, '%d/%m/%Y') AS dateImport " .
                "FROM Susar s " .
                "WHERE DATE_FORMAT(s.statusdate, '%d/%m/%Y')= '" . $statusdate->format('d/m/Y') . "' " .
                "GROUP BY DATE_FORMAT(s.dateImport, '%d/%m/%Y');" ;

        $stmt = $em->getConnection()->prepare($sql);

        $result = $stmt->executeQuery()->fetchAllAssociative();

            foreach ($result as $Susar) {
                $return["effectif"] = isset($return["effectif"])
                                            ? $return["effectif"] + $Susar["effectif"]
                                            : $Susar["effectif"];

                $return["dateImport_eff"] = isset($return["dateImport_eff"])
                                            ? $return["dateImport_eff"] . ", " . $Susar["dateImport"] . " (" . $Susar["effectif"] . ")"
                                            : $Susar["dateImport"] . " (" . $Susar["effectif"] . ")";
            }

        return $return;
    }

    /**
     * Retourne un array avec tous les susar pour l'export de pilotage
     *
     * @return Array
     */
    public function TousSusarPilotage(): Array
    {
        $em = $this->getEntityManager();

        // $sql = "SELECT susar.id AS idSUSAR, " .
        //             "susar.dateImport AS 'Date d\'import', " .
        //             "susar.DLPVersion AS 'Case Version',  " .
        //             "susar.num_eudract AS 'Num_EUDRACT', " .
        //             "susar.productName AS 'Produit', " .
        //             "susar.substanceName AS 'DCI', " .
        //             "intervenantsansm.DMM_pole_court, " .
        //             "mesureaction.Libelle AS 'Mesure/Action', " .
        //             "susar.Commentaire, " .
        //             "susar.utilisateurEvaluation AS 'Util. eval.', " .
        //             "susar.dateEvaluation AS 'Date eval.', " .
        //             "IF(ISNULL(susar.dateEvaluation),'Non','Oui') AS 'Susar évalué', " .
        //             "susar.pays_survenue AS 'Pays survenue', " .
        //             "IF(susar.pays_survenue = 'FR', 'Oui', 'Non') AS 'survenue en France' " .
        //         "FROM susar " .
        //     "LEFT JOIN intervenantsansm ON intervenantsansm.id = susar.intervenantANSM_id " .
        //     "LEFT JOIN mesureaction ON mesureaction.id = susar.MesureAction_id;" ;

            $sql = "SELECT susar.id AS idSUSAR, " .
                        "susar.dateImport, " .
                        "susar.DLPVersion,  " .
                        "susar.num_eudract, " .
                        "susar.productName, " .
                        "susar.substanceName, " .
                        "intervenantsansm.DMM_pole_court, " .
                        "mesureaction.Libelle, " .
                        "susar.Commentaire, " .
                        "susar.utilisateurEvaluation, " .
                        "susar.dateEvaluation, " .
                        "IF(ISNULL(susar.dateEvaluation),'Non','Oui') AS 'Susar_evalue', " .
                        "susar.pays_survenue, " .
                        "IF(susar.pays_survenue = 'FR', 'Oui', 'Non') AS 'survenue_france' " .
                    "FROM susar " .
                "LEFT JOIN intervenantsansm ON intervenantsansm.id = susar.intervenantANSM_id " .
                "LEFT JOIN mesureaction ON mesureaction.id = susar.MesureAction_id;" ;

        $stmt = $em->getConnection()->prepare($sql);

        $result = $stmt->executeQuery()->fetchAllAssociative();

        return $result;
    }
}
