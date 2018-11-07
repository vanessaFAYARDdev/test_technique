<?php

namespace App\Repository;

use App\Entity\Contract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    /**
     * @return Contract[] Returns an array of Contract objects
     */
    public function findById($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.id like :query')
            ->setParameter('query', "%". $value ."%")
            ->getQuery()
            ->getResult()
        ;
    }


    public function findOneById($value): ?Contract
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return [] Returns an array of data objects
     */
    public function findAllInTimePeriod($date1, $date2)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT contract.id, contract.start_at, contract.end_at, interim.last_name, interim.first_name, interim.zip_code, `status`.`name`
            FROM contract
            INNER JOIN interim ON interim.id = contract.interim_id
            INNER JOIN `status` ON `status`.`id` = contract.status_id
            WHERE contract.start_at >= :date1
            AND contract.end_at <= :date2
            ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['date1' => $date1, 'date2' => $date2]);

        return $stmt->fetchAll();
    }

}
