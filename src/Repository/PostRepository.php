<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
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
            ->join("p.comments","c")
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
    public  function cuntAllPosts(){
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->select('COUNT(p.id) as value');
        return $queryBuilder->getQuery()->getOneOrNullResult();

    }

     /*recuperer tout les posts de chaque  categorie
     dans le champ categorie il  faut que tu soie membre de la  categorie qu' ont te passe */
    /**
     * @param Category $category
     * @return array
     */
    public function findAllCategory( Category $category):array
    {
        $queryB=$this->createQueryBuilder('p');
        $queryB->where(':category MEMBER OF p.category' );
        $queryB->setParameter('category',$category);
        return $queryB->getQuery()->getResult();

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