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

        if ($search->getDebutCreationDate()) {
            $query = $query
                ->andWhere('s.creationdate >= :dcd')
                ->setParameter('dcd', $search->getDebutCreationDate());
        }

        if ($search->getFinCreationDate()) {
            $query = $query
                ->andWhere('s.creationdate <= :fcd')
                ->setParameter('fcd', $search->getFinCreationDate());
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

        if ($search->getEvalue()) {
            if ($search->getEvalue() === 'Non') {
                $query = $query
                    ->andWhere('s.dateEvaluation IS NULL');
            } elseif ($search->getEvalue() === 'Oui') {
                $query = $query
                    ->andWhere('s.dateEvaluation IS NOT NULL');
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
     * retourne le nombre de susar import pour la creationdate envoyé en parametre
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
        // dd($this->connexion);
        $sql = "START TRANSACTION;";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;";
        $sql .= "TRUNCATE bilansusar;";
        $sql .= "SET FOREIGN_KEY_CHECKS=1;";
        $sql .= "COMMIT;";

        $this->registry->getConnection()->query($sql);

    }


    //    /**
    //     * @return Susar[] Returns an array of Susar objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Susar
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
