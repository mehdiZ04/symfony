<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
    public function findauthorbyusername($username){
        $a=$this->getEntityManager();
        $query=$a->createQuery('SELECT a FROM App\Entity\Author a WHERE a.username = :username');
        $query->setParameter('username', $username);
        return $query->getResult();
    }
    public function trieAsc(){
        $a=$this->getEntityManager();
        $query=$a->createQuery('SELECT a FROM App\Entity\Author a Order BY a.username  ASC');
        return $query->getResult();
    }
    public function findauthorbyusernamee($username){
      return $this->createQueryBuilder('a')
            ->where('a.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getResult();    
    }
    public function trieDesc(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.username', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
