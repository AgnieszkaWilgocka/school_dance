<?php

namespace App\Repository;

use App\Entity\MyClasses;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MyClasses>
 *
 * @method MyClasses|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyClasses|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyClasses[]    findAll()
 * @method MyClasses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyClassesRepository extends ServiceEntityRepository
{
    public const PAGINATOR_ITEMS_PER_PAGE = 5;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyClasses::class);
    }

    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder();
    }

    public function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('my_classes');
    }

    public function queryByAuthor(User $user): QueryBuilder
    {
        $queryBuilder = $this->queryAll();

        $queryBuilder->andWhere('my_classes.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    public function save(MyClasses $myClasses): void
    {
       $this->_em->persist($myClasses);
       $this->_em->flush();
    }

   public function delete(MyClasses $myClasses): void
   {
       $this->_em->remove($myClasses);
       $this->_em->flush();
   }

//    /**
//     * @return MyClasses[] Returns an array of MyClasses objects
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

//    public function findOneBySomeField($value): ?MyClasses
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
