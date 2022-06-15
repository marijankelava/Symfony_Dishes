<?php

namespace App\Repository;

use App\Entity\Meal;
use App\Entity\Meals;
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
    
    public function getMeals(array $parameters)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.content', 'c')
           ->andWhere('m.id = entityId');
        
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

        $qb->leftJoin('m.category', 'c',)
            ->addSelect('c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id);
        
        return $qb->getQuery()->getResult();
    }
}
