<?php
namespace App\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Worker;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Worker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Worker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Worker[]    findAll()
 * @method Worker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Worker::class);
    }

    /**
     * @return Worker[]
     */
    public function findAllWithDetails(): array
    {
        $qb = $this->createQueryBuilder('w');
        $this->addJoinJob($qb);
        return $qb
            ->getQuery()
            ->getResult();
    }
    
    public function findOneWithDetails(int $id): Worker
    {
        $qb = $this->createQueryBuilder('w')
                    ->andWhere('w.id = :id')
                    ->setParameter('id', $id);
        $this->addJoinJob($qb);
        $this->addWorktimes($qb);
        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findCountOfWorkers(): ?int 
    {
        $qb = $this
            ->createQueryBuilder('w')
            ->select('COUNT(w)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findTopWorker(): ?Worker
    {
        $qb = $this
            ->createQueryBuilder('w')
            ->select('w')
            ->innerJoin('w.worktimes', 'wt')
            ->groupBy('w.id')
            ->orderBy('SUM(wt.cost)', 'DESC')
            ->setMaxResults(1);
        ;
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findTopWorkerMaxCost(int $id): ?float
    {
        $qb = $this
            ->createQueryBuilder('w')
            ->select('SUM(wt.cost)')
            ->innerJoin('w.worktimes', 'wt')
            ->andWhere('w.id = :id')
            ->setParameter('id', $id)
            ->groupBy('w.id');
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }


    public function addJoinJob(QueryBuilder $qb)
    {
        $qb
            ->addSelect('j')
            ->innerJoin('w.job', 'j')
        ;
    }

    public function addWorktimes(QueryBuilder $qb)
    {
        $qb
            ->addSelect('wt')
            ->leftJoin('w.worktimes', 'wt')
        ;
    }
}