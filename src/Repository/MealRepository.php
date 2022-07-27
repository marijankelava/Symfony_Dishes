<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    public function getMealsByCriteria(array $parameters)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.contents', 'con')
           ->addSelect('m.id, m.createdAt, con.title, con.description')
           ->orderBy('m.id', 'ASC');

        if (isset($parameters['lang'])) {
            $qb->andWhere('con.languageId = :lang')
            ->setParameter('lang', $parameters['lang']);
        }
        
        if (in_array('category', $parameters['with'])) {
            $qb->leftJoin('m.category', 'cat')
               ->addSelect('cat');
            $qb->LeftJoin('cat.contents', 'cont')
               ->addSelect('cont')
               ->andWhere('cat.id = cont.entityId')
               ->andWhere('cont.languageId = :lang')
               ->setParameter('lang', $parameters['lang']);

        }

        if(in_array('tags', $parameters['with'])) {
            $qb->leftJoin('m.tags', 'tag')
               ->addSelect('tag');
               $qb->LeftJoin('tag.contents', 'conte')
               ->addSelect('conte')
               ->andWhere('tag.id = conte.entityId')
               ->andWhere('conte.languageId = :lang')
               ->setParameter('lang', $parameters['lang']);
        }

        if(in_array('ingridients', $parameters['with'])) {
            $qb->leftJoin('m.ingridients', 'ing')
               ->addSelect('ing');
               $qb->LeftJoin('ing.contents', 'content')
               ->addSelect('content')
               ->andWhere('ing.id = content.entityId')
               ->andWhere('content.languageId = :lang')
               ->setParameter('lang', $parameters['lang']);
        }
        
        return $qb->setMaxResults((int) $parameters['per_page'])->setFirstResult($parameters['offset'])->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
 
    //Category controller function
    public function findByCategoryId($parameters, $categoryId)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.contents', 'con')
           ->addSelect('m.id, m.createdAt, con.title, con.description')
           ->orderBy('m.id', 'ASC');

        $qb->leftJoin('m.category', 'cat',)
            //->addSelect('cat')
            ->andWhere('cat.id IN (:id)')
            ->setParameter('id', $categoryId);
    
            if (isset($parameters['lang'])) {
                $qb->andWhere('con.languageId = :lang')
                ->setParameter('lang', $parameters['lang']);
            }
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    //Tag controller function
    public function findByTagId($parameters, $tagId)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.contents', 'con')
           ->addSelect('m.id, m.createdAt, con.title, con.description')
           ->orderBy('m.id', 'ASC');

        $qb->leftJoin('m.tags', 'tag',)
            //->addSelect('tag')
            ->andWhere('tag.id IN (:id)')
            ->setParameter('id', $tagId);
    
            if (isset($parameters['lang'])) {
                $qb->andWhere('con.languageId = :lang')
                ->setParameter('lang', $parameters['lang']);
            }
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function getMealsCount()
    {
        return $this->createQueryBuilder('m')
        ->select('count(m.id)')
        ->getQuery()
        ->getSingleScalarResult();
    }
}
