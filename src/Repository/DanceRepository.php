<?php

namespace App\Repository;

use App\Entity\Dance;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dance>
 *
 * @method Dance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dance[]    findAll()
 * @method Dance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DanceRepository extends ServiceEntityRepository
{

    public const PAGINATOR_ITEMS_PER_PAGE = 6;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dance::class);
    }

    public function queryAll(array $filters): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->where('dance.field > 0')
            ->leftJoin('dance.tags', 'tags')
            ->orderBy('dance.name', 'DESC');



        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    public function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('dance');
    }

    /**
     * @param Dance $dance
     *
     * @return void
     */
    public function save(Dance $dance): void
    {
        $this->_em->persist($dance);
        $this->_em->flush();
    }

    /**
     * @param Dance $dance
     *
     * @return void
     */
    public function delete(Dance $dance): void
    {
        $this->_em->remove($dance);
        $this->_em->flush();
    }

    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if(isset($filters['tag']) && $filters['tag'] instanceof Tag) {
            $queryBuilder->andWhere('tags IN (:tag)')
                ->setParameter('tag', $filters['tag']);
        }

        return $queryBuilder;
    }
//    public function remove(Dance $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->remove($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }

//    /**
//     * @return Dance[] Returns an array of Dance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dance
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
