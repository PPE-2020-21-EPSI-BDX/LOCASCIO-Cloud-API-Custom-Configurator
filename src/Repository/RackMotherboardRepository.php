<?php

namespace App\Repository;

use App\Entity\RackMotherboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RackMotherboard>
 *
 * @method RackMotherboard|null find($id, $lockMode = null, $lockVersion = null)
 * @method RackMotherboard|null findOneBy(array $criteria, array $orderBy = null)
 * @method RackMotherboard[]    findAll()
 * @method RackMotherboard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RackMotherboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RackMotherboard::class);
    }

    public function add(RackMotherboard $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RackMotherboard $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RackMotherboard[] Returns an array of RackMotherboard objects
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

//    public function findOneBySomeField($value): ?RackMotherboard
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
