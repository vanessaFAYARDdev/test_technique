<?php

namespace App\Repository;

use App\Entity\Interim;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Interim|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interim|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interim[]    findAll()
 * @method Interim[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterimRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Interim::class);
    }

    /**
     * @return Interim[] Returns an array of Interim objects
     */

    public function findByName($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.firstName like :query')
            ->setParameter('query', "%". $value ."%")
            //->orderBy('i.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findById($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.id like :query')
            ->setParameter('query', "%". $value ."%")
            //->orderBy('i.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Interim
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
