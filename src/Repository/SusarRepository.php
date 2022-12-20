<?php

namespace App\Repository;

use App\Entity\Susar;
use DateTimeInterface;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Susar::class);
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
             
            $test = $this->createQueryBuilder('s')
                 ->select('count(s.id)')
                 ->andWhere('s.master_id = :val')
                 ->setParameter('val', $value)
                 ->getQuery()
                 ->getSingleScalarResult()
            ;

            if ($test > 0) {
                return false;
            } else {
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
                   ->orderBy('s.id', 'ASC')
                   ->getQuery()
                   ->getResult()
               ;
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
