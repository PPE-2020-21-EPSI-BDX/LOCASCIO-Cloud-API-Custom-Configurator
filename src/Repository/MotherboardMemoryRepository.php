<?php

namespace App\Repository;

use App\Entity\MotherboardMemory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MotherboardMemory>
 *
 * @method MotherboardMemory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardMemory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardMemory[]    findAll()
 * @method MotherboardMemory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardMemoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardMemory::class);
    }

    public function add(MotherboardMemory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MotherboardMemory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MotherboardMemory[] Returns an array of MotherboardMemory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MotherboardMemory
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
