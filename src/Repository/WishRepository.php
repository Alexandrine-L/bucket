<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function findWishList(int $page = 1)
    {
        //en QueryBuilder
        $queryBuilber = $this->createQueryBuilder('w');
        $offset = ($page - 1) * 20;
        $queryBuilber->setFirstResult($offset);
        $queryBuilber->andWhere('w.isPublished = true');
        $queryBuilber->addOrderBy('w.dateCreated', 'DESC');
        $queryBuilber->setMaxResults(20);

        $query = $queryBuilber->getQuery();

        $result = $query->getResult();

        return $result;

        /*
        //en DQL
        $dql = "SELECT w 
                FROM App\Entity\Wish w
                WHERE w.isPublished = true";

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery($dql);

        //limite le nombre de resultats
        $query->setMaxResults(20);

        $result = $query->getResult();

        return $result;
        */
    }

    // /**
    //  * @return Wish[] Returns an array of Wish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wish
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
