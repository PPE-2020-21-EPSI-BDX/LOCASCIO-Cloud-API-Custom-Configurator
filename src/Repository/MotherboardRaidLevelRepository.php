<?php

namespace App\Repository;

use App\Entity\MotherboardRaidLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MotherboardRaidLevel>
 *
 * @method MotherboardRaidLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotherboardRaidLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotherboardRaidLevel[]    findAll()
 * @method MotherboardRaidLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotherboardRaidLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotherboardRaidLevel::class);
    }

    public function add(MotherboardRaidLevel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MotherboardRaidLevel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MotherboardRaidLevel[] Returns an array of MotherboardRaidLevel objects
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

//    public function findOneBySomeField($value): ?MotherboardRaidLevel
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
