<?php

namespace App\Repository;

use App\Entity\RaidCardInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaidCardInterface>
 *
 * @method RaidCardInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method RaidCardInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method RaidCardInterface[]    findAll()
 * @method RaidCardInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaidCardInterfaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaidCardInterface::class);
    }

    public function add(RaidCardInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RaidCardInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RaidCardInterface[] Returns an array of RaidCardInterface objects
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

//    public function findOneBySomeField($value): ?RaidCardInterface
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
