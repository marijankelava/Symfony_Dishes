<?php

namespace App\Repository;

use App\Entity\Ingridient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Ingridient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingridient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingridient[]    findAll()
 * @method Ingridient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngridientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingridient::class);
    }

    // /**
    //  * @return Ingridients[] Returns an array of Ingridients objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ingridients
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getIngridients($parameters)
    {
        $lang = $parameters['lang'];

        $qb = $this->createQueryBuilder('ing');

        $qb->leftJoin('ing.contents', 'con')
            ->addSelect('con.title')
            ->andWhere('ing.id = con.entityId');
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY); 
    }

    public function getIngridientsTitle($parameters, $with)
    {
        $lang = $parameters['lang'];

        $qb = $this->createQueryBuilder('ing');

        if (in_array('ingridients', $with)) {
            $qb->leftJoin('ing.meals', 'm')
               ->addSelect('m');
            $qb->leftJoin('ing.contents', 'cont')
               ->select('cont.title')
               ->andWhere('ing.id = cont.entityId')
               ->orderBy('m.id', 'ASC');
        }
        
        if (isset($parameters['lang'])) {
            $qb->andWhere('cont.languageId = :lang')
            ->setParameter('lang', $parameters['lang']);
        }
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY); 
    }
}
