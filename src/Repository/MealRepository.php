<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

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

    public function getAllMeals()
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.contents', 'con')
           ->addSelect('m.id, con.title, con.description')
           ->orderBy('m.id', 'ASC');

        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
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
            $qb->leftJoin('cat.contents', 'cont')
               ->addSelect('cont');

            if (isset($parameters['category'])) {
                $categoryId = explode(',', $parameters['category']);
                $qb->andWhere('cat.id IN (:id)')
                   ->setParameter('id', $categoryId);
            }
            
            $qb->andWhere('cat.id = cont.entityId')
               ->andWhere('cont.languageId = :lang')
               ->setParameter('lang', $parameters['lang']);

        }

        if(in_array('tags', $parameters['with'])) {
            $qb->leftJoin('m.tags', 'tag')
               ->addSelect('tag');
               $qb->leftJoin('tag.contents', 'conte')
               ->addSelect('conte');

               if (isset($parameters['tags'])) {
                $tagsId = explode(',', $parameters['tags']);
                $qb->andWhere('tag.id IN (:id)')
                   ->setParameter('id', $tagsId);
            }

            $qb->andWhere('tag.id = conte.entityId')
               ->andWhere('conte.languageId = :lang')
               ->setParameter('lang', $parameters['lang']);
        }

        if(in_array('ingridients', $parameters['with'])) {
            $qb->leftJoin('m.ingridients', 'ing')
               ->addSelect('ing');
               $qb->leftJoin('ing.contents', 'content')
               ->addSelect('content')
               ->andWhere('ing.id = content.entityId')
               ->andWhere('content.languageId = :lang')
               ->setParameter('lang', $parameters['lang']);
        }
        
        $query = $qb->setMaxResults($parameters['limit'])->setFirstResult($parameters['offset'])->getQuery()->setHydrationMode(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

        return $query;
    }
 
    //Category controller function
    public function getMealsByCategory($parameters, $categoryId)
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
    public function getMealsByTags($parameters, $tagId)
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
