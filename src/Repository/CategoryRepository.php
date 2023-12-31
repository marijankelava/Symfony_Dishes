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

    public function getCategoryTitle($parameters, $with)
    {
        $lang = $parameters['lang'];

        $qb = $this->createQueryBuilder('cat');

        if (in_array('category', $with)) {
            $qb->leftJoin('cat.meals', 'm')
               ->addSelect('m');
            $qb->leftJoin('cat.contents', 'cont')
               ->select('cont.title')
               ->andWhere('cat.id = cont.entityId')
               ->orderBy('m.id', 'ASC');
        }
        
        if (isset($parameters['lang'])) {
            $qb->andWhere('cont.languageId = :lang')
            ->setParameter('lang', $parameters['lang']);
        }
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY); 
    }
}
