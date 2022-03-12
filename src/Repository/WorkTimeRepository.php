<?php
namespace App\Repository;

use App\Entity\WorkTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkTime[]    findAll()
 * @method WorkTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkTime::class);
    }


    public function findLatestTenWorkTimes(): ?array
    {
        $qb = $this
            ->createQueryBuilder('wt')
            ->orderBy('wt.createdAt', 'DESC')
            ->setMaxResults(10);

        $this->addJoinWorker($qb);
        $this->addJoinProject($qb);

        return $qb->getQuery()->getResult();
    }

    public function findWorktimesCount():  ?int
    {
        $qb = $this
            ->createQueryBuilder('wt')
            ->select('COUNT(wt)')
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function addJoinWorker(QueryBuilder $qb)
    {
        $qb
            ->addSelect('w')
            ->innerJoin('wt.worker', 'w')
        ;
    }

    public function addJoinProject(QueryBuilder $qb)
    {
        $qb
            ->addSelect('p')
            ->innerJoin('wt.project', 'p')
        ;
    }
}