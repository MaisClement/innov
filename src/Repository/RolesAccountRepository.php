<?php

namespace App\Repository;

use App\Entity\RolesAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RolesAccount>
 *
 * @method RolesAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method RolesAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method RolesAccount[]    findAll()
 * @method RolesAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolesAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RolesAccount::class);
    }

//    /**
//     * @return RolesAccount[] Returns an array of RolesAccount objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RolesAccount
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
