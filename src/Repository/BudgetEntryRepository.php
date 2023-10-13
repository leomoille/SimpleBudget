<?php

namespace App\Repository;

use App\Entity\BudgetEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BudgetEntry>
 *
 * @method BudgetEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method BudgetEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method BudgetEntry[]    findAll()
 * @method BudgetEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BudgetEntry::class);
    }

//    /**
//     * @return BudgetEntry[] Returns an array of BudgetEntry objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BudgetEntry
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
