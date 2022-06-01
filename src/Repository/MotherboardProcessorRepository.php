<?php

namespace App\Repository;

use App\Entity\MotherboardProcessor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MotherboardProcessor>
 *
 * @method MotherboardProcessor|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardProcessor|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardProcessor[]    findAll()
 * @method MotherboardProcessor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardProcessorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardProcessor::class);
    }

    public function add(MotherboardProcessor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MotherboardProcessor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MotherboardProcessor[] Returns an array of MotherboardProcessor objects
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

//    public function findOneBySomeField($value): ?MotherboardProcessor
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
