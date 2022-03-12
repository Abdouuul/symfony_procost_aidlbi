<?php
namespace App\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Project;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }
    
    /**
     * @return Project[]
     */
    public function findAllWithDetails(): ?array
    {
        $qb = $this->createQueryBuilder('p');
        $this->addWorktimes($qb);
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findOneWithDetails(int $id): Project
    {
        $qb = $this->createQueryBuilder('p')
                    ->andWhere('p.id = :id')
                    ->setParameter('id', $id);
        $this->addWorktimes($qb);
        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findLatestCreatedProjects(): ?array
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }

    public function findCountOfOngoingProjects(): ?int
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->andWhere('p.deliveryDate is NOT NULL ');
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findCountOfProjects(): ?int
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->select('COUNT(p)')
            ;

        return $qb->getQuery()->getSingleScalarResult();
    }


    public function findCountOfDelieveredProjects(): ?int
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->andWhere('p.deliveryDate is NULL ');

        return $qb->getQuery()->getSingleScalarResult() ;
    }


    public function addWorktimes(QueryBuilder $qb)
    {
        $qb
            ->addSelect('wt')
            ->leftJoin('p.worktimes', 'wt')
        ;
    }
}