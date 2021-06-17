<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public  function cuntAllCategory(){
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->select('COUNT(p.id) as value');
        return $queryBuilder->getQuery()->getOneOrNullResult();

    }





    /**
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public  function getPaginatedPosts(int $page,int $limit):Paginator
    {
        // dump(($page-1)*$limit);
        return new Paginator( $this->createQueryBuilder("p")
            ->addSelect( "c")
            ->join("p.post","c")
            ->setMaxResults($limit)
            ->setFirstResult(($page-1)*$limit));
        //->groupBy("p.id")
        //->getQuery()
        //->getResult();
    }



    /**
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public  function category(){
        $queryBuilder = $this->createQueryBuilder('c')
                   ->join("c.category","c")
                   ->andWhere('c.category LIKE :name');
        return $queryBuilder->getQuery()
                            ->getResult();


    }




    /**
     * @param Category $category
     * @return array
     */
    public  function allCategory(Category $category):array{
        $queryBuilder = $this->createQueryBuilder('c')
            ->where("c.category=:economie")
            ->setParameter('economie', $category);
        return $queryBuilder->getQuery()
            ->getResult();}






}
