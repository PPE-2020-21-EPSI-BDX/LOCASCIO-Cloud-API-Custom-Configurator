<?php

namespace App\Repository;

use App\Entity\RackFormFactor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RackFormFactor>
 *
 * @method RackFormFactor|null find($id, $lockMode = null, $lockVersion = null)
 * @method RackFormFactor|null findOneBy(array $criteria, array $orderBy = null)
 * @method RackFormFactor[]    findAll()
 * @method RackFormFactor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RackFormFactorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RackFormFactor::class);
    }

    public function add(RackFormFactor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RackFormFactor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RackFormFactor[] Returns an array of RackFormFactor objects
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

//    public function findOneBySomeField($value): ?RackFormFactor
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
