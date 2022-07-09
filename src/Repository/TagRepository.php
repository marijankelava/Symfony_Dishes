<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    // /**
    //  * @return Tags[] Returns an array of Tags objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tags
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getTags($parameters)
    {
        $lang = $parameters['lang'];

        $qb = $this->createQueryBuilder('tag');

        $qb->leftJoin('tag.contents', 'con')
            ->addSelect('con.title')
            ->andWhere('tag.id = con.entityId');
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY); 
    }

    public function getTagsTitle($parameters, $with)
    {
        $lang = $parameters['lang'];

        $qb = $this->createQueryBuilder('tag');

        if (in_array('tags', $with)) {
            $qb->leftJoin('tag.meals', 'm')
               ->addSelect('m');
            $qb->leftJoin('tag.contents', 'cont')
               ->select('cont.title')
               ->andWhere('tag.id = cont.entityId')
               ->orderBy('m.id', 'ASC');
        }
        
        if (isset($parameters['lang'])) {
            $qb->andWhere('cont.languageId = :lang')
            ->setParameter('lang', $parameters['lang']);
        }
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY); 
    }
}
