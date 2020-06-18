<?php

namespace App\Repository;

use App\Entity\Biens;
use Doctrine\ORM\Query;
use App\Entity\PropertySearch;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Biens|null find($id, $lockMode = null, $lockVersion = null)
 * @method Biens|null findOneBy(array $criteria, array $orderBy = null)
 * @method Biens[]    findAll()
 * @method Biens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Biens::class);
    }

    /**
     * Undocumented function
     *
     * @param PropertySearch $search
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        if (!$search->getMaxPrice() && !$search->getMinSurface()) {
            $query = $this->getEntityManager()
                ->createQuery(
                    'SELECT b FROM App:Biens b WHERE b.statuts = 0 ORDER BY b.loyers ASC'
                );
        }

        if ($search->getMaxPrice()) {
            $query = $this->getEntityManager()
            ->createQuery(
                'SELECT b FROM App:Biens b WHERE b.statuts = 0 AND b.loyers <= :maxprice ORDER BY b.loyers DESC'
            )
            ->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getMinSurface()) {
            $query = $this->getEntityManager()
            ->createQuery(
                'SELECT b FROM App:Biens b WHERE b.statuts = 0 AND b.surfaces <= :minsurface ORDER BY b.loyers DESC'
            )
            ->setParameter('minsurface', $search->getMinSurface());
        }

        return $query;
    }

    // /**
    //  * @return Biens[] Returns an array of Biens objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Biens
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
