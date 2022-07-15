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

    public function getCategory($parameters)
    {
        $lang = $parameters['lang'];

        $qb = $this->createQueryBuilder('cat');

        $qb->leftJoin('cat.contents', 'con')
            ->addSelect('con.title')
            ->andWhere('cat.id = con.entityId');    
        
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

    public function getRawCategories($parameters, $with)
    {
        $conn = $this->getEntityManager()->getConnection();

        // calculate offset
        $offset = ((int) $parameters['page'] - 1) * (int) $parameters['per_page'];

        if (in_array('category', $with)) {
            $sql = 'SELECT category.id, category.slug, content.title, meal.id FROM category';
            $sql .= ' RIGHT JOIN meal_category ON category.id = meal_category.category_id';
            $sql .= ' RIGHT JOIN meal ON meal.id = meal_category.meal_id';
            $sql .= ' LEFT JOIN content_category ON category.id = content_category.category_id';
            $sql .= ' LEFT JOIN content ON content.id = content_category.content_id';
        

        /*if (in_array('category', $with)) {
            $sql .= ' LEFT JOIN meal_category ON meal.id = meal_category.meal_id';
            $sql .= ' LEFT JOIN category ON category.id = meal_category.category_id';
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
    }   
}
