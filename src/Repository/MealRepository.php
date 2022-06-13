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
        
        if (isset($parameters['tag'])) {
            $qb->leftJoin('m.tags', 't')
            ->andWhere('t.id IN (:id)')
            ->setParameter('id', explode(',', $parameters['tag']));
            /*if (isset($parameters['with_category'])) {
                $qb->addSelect('c.title');
            }*/
        }
        return $qb->setMaxResults($parameters['per_page'])->setFirstResult(0)->getQuery()->getResult(Query::HYDRATE_ARRAY);

    }

    public function getRawSqlMeals($parameters)
    {
        $conn = $this->getEntityManager()->getConnection();

        // calculate offset
        $offset = ((int) $parameters['page'] - 1) * (int) $parameters['per_page'];

        $lang = $parameters['lang'];
        
        switch ($lang) {
            case "hr":
                $sql = 'SELECT content.id, content.naslov_jela, content.opis_jela FROM content';
                if (isset($parameters['category'])) {
                    $sql .= ' LEFT JOIN meal_category ON content.id = meal_category.meal_id
                    WHERE category_id = :category';
                }
                if (isset($parameters['tag'])) {
                    $sql .= ' LEFT JOIN meal_tag ON content.meal_id = meal_tag.meal_id
                    WHERE tag_id = :tag';
                }
                break;
            
            default:
                /*if(isset($parameters['with'])) {
                    $sql = 'WITH ingridient AS (SELECT ingridient.title FROM ingridient)';
                }*/
                $sql = 'SELECT meal.id, meal.title, meal.description FROM meal';
                if (isset($parameters['category'])) {
                    $sql .= ' LEFT JOIN meal_category ON meal.id = meal_id
                    WHERE category_id = :category';
                }
                if (isset($parameters['tag'])) {
                    $sql .= ' LEFT JOIN meal_tag ON meal.id = meal_tag.meal_id
                    WHERE tag_id = :tag';
                }
                break;
        }

        $sql .= ' LIMIT :limit OFFSET :offset';
        
        $stmt = $conn->prepare($sql);

        if (isset($parameters['category'])) {
            $stmt->bindValue('category', $parameters['category']);
        }

        if(isset($parameters['tag'])){
            $stmt->bindValue('tag', $parameters['tag']);
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

        $qb->leftJoin('m.category', 'c',)
            ->addSelect('c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id);
        
        return $qb->getQuery()->getResult();
    }

    /*public function getThoseMeals($parameters)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM meal WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('id', $parameters['id']);
        $resultSet = $stmt->executeQuery([]);

        return $resultSet->fetchAllAssociative();
        
    }*/

    /*
    public function findOneBySomeField($value): ?Meals
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
