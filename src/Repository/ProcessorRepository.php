<?php

namespace App\Repository;

use App\Entity\Processor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Processor>
 *
 * @method Processor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Processor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Processor[]    findAll()
 * @method Processor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Processor::class);
    }

    /**
     * @param Processor $entity
     * @param bool $flush
     */
    public function add(Processor $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Processor $entity
     * @param bool $flush
     */
    public function remove(Processor $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Allows to get the name of all processors by a specific socket and tdp
     * @param string $socket
     * @param int $tdp
     * @return array
     * @throws Exception
     */
    public function findAllProcessorsThanSocketAndTdp(string $socket, int $tdp): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $stmt = $conn->prepare(
            "SELECT 
                x.id
            FROM ppe2_custom_configurator.processor x
            WHERE x.socket IN (:socket) AND x.tdp < :tdp"
        );
        $resultSet = $stmt->executeQuery(['socket' => $socket, 'tdp' => $tdp]);

        return $resultSet->fetchAllAssociative();
    }

    // /**
    //  * @return Processor[] Returns an array of Processor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Processor
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
