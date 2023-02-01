<?php

namespace App\Repository;

use App\Entity\Glossaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Glossaire>
 *
 * @method Glossaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Glossaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Glossaire[]    findAll()
 * @method Glossaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlossaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Glossaire::class);
    }

    public function save(Glossaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Glossaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * retourne un tableau des 5 premiers elements du glossaire
     *
     * @return array
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
     * retourne un tableau des elements recherchés par indcation dans le glossaire 
     *
     * @param string $value : indication recherchée
     * @return array
     */
    public function findByIndication(string $value): array
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.itemGlossaire LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('g.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Glossaire[] Returns an array of Glossaire objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Glossaire
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
