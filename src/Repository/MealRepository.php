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

    // /**
    //  * @return Meals[] Returns an array of Meals objects
    //  */
    
    /*public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }*/
    
    public function getMeals(array $parameters, ?array $with)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.contents', 'con')
           ->addSelect('con.title, con.description')
           ->orderBy('con.id', 'ASC');

        if (isset($parameters['lang'])) {
            $qb->andWhere('con.languageId = :lang')
            ->setParameter('lang', $parameters['lang']);
        }

        $val = "App\Entity\Content";

        if (in_array('category', $with)) {
            $qb->leftJoin('m.category', 'cat')
               ->addSelect('cat');
            $qb->leftJoin('cat.contents', 'cont')
               ->addSelect('cont.title')
               ->andWhere('cat.id = cont.entityId');
        }

        if(in_array('tags', $with)) {
            $qb->leftJoin('m.tags', 'tag')
               ->addSelect('tag');
        }

        if(in_array('ingridients', $with)) {
            $qb->leftJoin('m.ingridients', 'ing')
               ->addSelect('ing');
        }
        
    return $qb->setMaxResults($parameters['per_page'])->setFirstResult(0)->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function getMeals2(array $parameters, ?array $with)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.contents', 'con')
           ->addSelect('con.title, con.description')
           ->orderBy('con.id', 'ASC');

        if (isset($parameters['lang'])) {
            $qb->andWhere('con.languageId = :lang')
            ->setParameter('lang', $parameters['lang']);
        }

        $val = "App\Entity\Content";

        if (in_array('category', $with)) {
            $qb->leftJoin('m.category', 'cat')
               ->addSelect('cat');
        }

        if(in_array('tags', $with)) {
            $qb->leftJoin('m.tags', 'tag')
               ->addSelect('tag');
        }

        if(in_array('ingridients', $with)) {
            $qb->leftJoin('m.ingridients', 'ing')
               ->addSelect('ing');
        }
        
    return $qb->setMaxResults($parameters['per_page'])->setFirstResult(0)->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function getRawSqlMeals($parameters)
    {
        $conn = $this->getEntityManager()->getConnection();

        // calculate offset
        //$offset = ((int) $parameters['page'] - 1) * (int) $parameters['per_page'];

        $lang = $parameters['lang'];
    }   

    //Category controller function
    public function findByCategoryId(int $id)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.category', 'cat',)
            ->addSelect('cat')
            ->andWhere('cat.id = :id')
            ->setParameter('id', $id);
        
        return $qb->getQuery()->getResult();
    }
}
