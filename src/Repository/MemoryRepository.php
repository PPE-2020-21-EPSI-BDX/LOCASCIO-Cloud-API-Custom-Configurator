<?php

namespace App\Repository;

use App\Entity\Memory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Memory>
 *
 * @method Memory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Memory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Memory[]    findAll()
 * @method Memory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Memory::class);
    }

    /**
     * @param Memory $entity
     * @param bool $flush
     */
    public function add(Memory $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Memory $entity
     * @param bool $flush
     */
    public function remove(Memory $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Allows to get the id of all memories by a specific frequency and type
     * @param string $type
     * @param int $freq
     * @return array
     * @throws Exception
     */
    public function findAllMemoriesThanFreqAndType(string $type, int $freq): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $stmt = $conn->prepare(
            "SELECT 
                x.id
            FROM ppe2_custom_configurator.memory x
            WHERE x.type = substring_index(:type, '-', 1) AND x.freq <= :freq"
        );
        $resultSet = $stmt->executeQuery(['type' => $type, 'freq' => $freq]);

        return $resultSet->fetchAllAssociative();
    }

    // /**
    //  * @return Memory[] Returns an array of Memory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Memory
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
