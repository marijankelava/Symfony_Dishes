<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

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

    public function getAll() {
        $qb = $this->createQueryBuilder('c');     
    
    
        return $qb->getQuery()->getArrayResult();
    }

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

    //Category controller function
    public function getMealCategories($id)
    {
        $qb = $this->createQueryBuilder('cat');

        $qb->leftJoin('cat.contents', 'con',)
            ->addSelect('con.title')
            ->andWhere('cat.id = :id')
            ->setParameter('id', $id);
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function getCategories($parameters)
    {
        $lang = $parameters['lang'];

        $qb = $this->createQueryBuilder('cat');

        $qb->leftJoin('cat.contents', 'con')
           //->leftJoin('cat.meals', 'm')
            ->addSelect('con.title')
            ->andWhere('con.languageId = :lang')
            ->setParameter('lang', $lang);
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function getCategoryTitle($parameters)
    {
        $lang = $parameters['lang'];
        $val = "App\Entity\Content";

        $qb = $this->createQueryBuilder('cat');

        $qb->leftJoin('cat.contents', 'con')
            ->addSelect('con.title')
            ->andWhere('con.languageId = :lang')
            ->setParameter('lang', $lang);
            /*->andWhere('con.fqcn = :val')
            ->setParameter('val', $val);*/

        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY); 
    }

    public function getCategory($parameters)
    {
        $lang = $parameters['lang'];
        $val = "App\Entity\Content";

        $qb = $this->createQueryBuilder('cat');

        $qb->leftJoin('cat.contents', 'con')
            ->addSelect('con.title')
            ->andWhere('cat.id = con.entityId');
            /*->andWhere('con.languageId = :lang')
            ->setParameter('lang', $lang)
            ->andWhere('con.fqcn = :val')
            ->setParameter('val', $val);
        /*$qb->leftJoin('cat.meals', 'm')
           ->addSelect('cat')
           ->distinct();*/       
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY); 
    }
}
