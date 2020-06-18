<?php

namespace App\Repository;

use App\Entity\Locataires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Locataires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Locataires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Locataires[]    findAll()
 * @method Locataires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocatairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Locataires::class);
    }

    // /**
    //  * @return Locataires[] Returns an array of Locataires objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Locataires
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function foundEmail()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT l.email FROM App:Locataires l WHERE l.newsletter = 1'
            );
        
        return $query->getResult();
    }

    public function nbrInscrit()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(l) FROM App:Locataires l'
            );

        return $query->getResult();
    }

    public function locatairesDataChart()
    {
        $qb = $this->createQueryBuilder('l')
            ->select("COUNT(l) locataire, DATE_FORMAT(l.date_add, '%m/%Y') mois")
            ->where('YEAR(l.date_add) = 2020')
            ->groupBy('mois')
        ;
        return $qb->getQuery()->getResult();
    }
}
