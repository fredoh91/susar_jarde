<?php

namespace App\Repository;

use App\Entity\TermeRechAttribDMMpole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TermeRechAttribDMMpole>
 *
 * @method TermeRechAttribDMMpole|null find($id, $lockMode = null, $lockVersion = null)
 * @method TermeRechAttribDMMpole|null findOneBy(array $criteria, array $orderBy = null)
 * @method TermeRechAttribDMMpole[]    findAll()
 * @method TermeRechAttribDMMpole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TermeRechAttribDMMpoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TermeRechAttribDMMpole::class);
    }

    public function save(TermeRechAttribDMMpole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TermeRechAttribDMMpole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


   /**
    * @return TermeRechAttribDMMpole[] Returns an array of TermeRechAttribDMMpole objects
    */
   public function TermeRechByType(string $value): array
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.TypeRech = :val')
           ->setParameter('val', $value)
           ->orderBy('t.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }


//    /**
//     * @return TermeRechAttribDMMpole[] Returns an array of TermeRechAttribDMMpole objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TermeRechAttribDMMpole
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
