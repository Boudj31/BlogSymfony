<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findLast() {

        // SELECT * FROM article ORDER BY created_at LIMIT 3
        return $this->createQueryBuilder('article')
                     ->orderBy('article.createdAt', 'DESC')
                     ->setMaxResults(3)
                     ->getQuery()
                     ->getResult();
    }

    public function lastArticle(){
        return $this->createQueryBuilder('article')
          ->orderBy('article.createdAt', 'DESC')
          ->setMaxResults(1)
          ->getQuery()
          ->getOneOrNullResult();
   }

   // SELECT * WHERE article WHERE title LIKE '%P%' OR content LIKE '%mot%' OR summary LIKE '%mot%'
   public function findByWord(string $word)
   {
       return ($queryBuilder = $this->createQueryBuilder('a'))
           ->where($queryBuilder->expr()->like('a.title', ':word'))
           ->orWhere($queryBuilder->expr()->like('a.summary', ':word'))
           ->orWhere($queryBuilder->expr()->like('a.content', ':word'))
           ->setParameter('word', '%'.$word.'%')
           ->getQuery()
           ->getResult();
   }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
