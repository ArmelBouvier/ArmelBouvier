<?php

namespace App\Repository;

use App\Entity\TechGenre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TechGenre|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechGenre|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechGenre[]    findAll()
 * @method TechGenre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechGenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechGenre::class);
    }

    // /**
    //  * @return TechGenre[] Returns an array of TechGenre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TechGenre
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
