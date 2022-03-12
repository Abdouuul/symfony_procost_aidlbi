<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Job;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    /**
     * @return Job[]
     */
    public function findAllWithDetails(): ?array
    {
        $qb = $this->createQueryBuilder('j');
        $this->addJoinWorkers($qb);
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findOneWithDetails(int $id): Job
    {
        $qb = $this->createQueryBuilder('j');
        $this->addJoinWorkers($qb);
        return $qb
            ->andWhere('j.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function addJoinWorkers(QueryBuilder $qb)
    {
        $qb
            ->addSelect('w')
            ->leftJoin('j.workers', 'w')
        ;
    }
}