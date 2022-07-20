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

        if (in_array('category', $with)) {
            $qb->leftJoin('m.category', 'cat')
               ->addSelect('cat');
            /*$qb->leftJoin('cat.contents', 'cont')
               ->addSelect('cont.title')
               ->andWhere('cat.id = cont.entityId');*/
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

    public function getMealsByCriteria(array $parameters, ?array $with)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.contents', 'con')
           ->addSelect('m.id, m.createdAt, con.title, con.description')
           ->orderBy('m.id', 'ASC');

        if (isset($parameters['lang'])) {
            $qb->andWhere('con.languageId = :lang')
            ->setParameter('lang', $parameters['lang']);
        }
        
        if (in_array('category', $with)) {
            $qb->leftJoin('m.category', 'cat')
               ->addSelect('cat');
            $qb->LeftJoin('cat.contents', 'cont')
               ->addSelect('cont')
               ->andWhere('cat.id = cont.entityId')
               ->andWhere('cont.languageId = :lang')
               ->setParameter('lang', $parameters['lang']);

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

    public function getRawSqlMeals($parameters, $with)
    {
        $conn = $this->getEntityManager()->getConnection();

        // calculate offset
        $offset = ((int) $parameters['page'] - 1) * (int) $parameters['per_page'];

        $sql = 'SELECT meal.id, meal.created_at, content.title, content.description FROM meal';

        $sql .= ' LEFT JOIN content_meal ON meal.id = content_meal.meal_id';

        $sql .= ' LEFT JOIN content ON content.id = content_meal.content_id';

        if (in_array('category', $with)) {
            $sql .= ' LEFT JOIN meal_category ON meal.id = meal_category.meal_id';
            $sql .= ' LEFT JOIN category ON category.id = meal_category.category_id';

            //$sql .= ' LEFT JOIN content_category ON category.id = content_category.category_id';
            //$sql .= ' LEFT JOIN content ON con.id = content_category.content_id';
        }

        /*if (in_array('tags', $with)) {
            $sql .= ' LEFT JOIN meal_tag ON meal.id = meal_tag.meal_id';
            $sql .= ' LEFT JOIN tag ON tag.id = meal_tag.tag_id';
        }*/

        if (isset($parameters['lang'])) {
            $sql .= ' WHERE content.language_id = :lang';
        }

        $sql .= ' ORDER BY meal.id ASC';

        $sql .= ' LIMIT :limit OFFSET :offset';

        $stmt = $conn->prepare($sql);

        if (isset($parameters['lang'])) {
            $stmt->bindValue('lang', $parameters['lang']);
        }

        $stmt->bindValue('limit', $parameters['per_page'], \PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);

        $resultSet = $stmt->executeQuery();
    
        return $resultSet->fetchAllAssociative();
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
