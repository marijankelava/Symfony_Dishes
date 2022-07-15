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

    public function getRawIngridients($parameters, $with)
    {
        $conn = $this->getEntityManager()->getConnection();

        // calculate offset
        $offset = ((int) $parameters['page'] - 1) * (int) $parameters['per_page'];

        if (in_array('ingridients', $with)) {
            $sql = 'SELECT ingridient.id, ingridient.slug, content.title, meal.id FROM ingridient';
            $sql .= ' RIGHT JOIN meal_ingridient ON ingridient.id = meal_ingridient.ingridient_id';
            $sql .= ' RIGHT JOIN meal ON meal.id = meal_ingridient.meal_id';
            $sql .= ' LEFT JOIN content_ingridient ON ingridient.id = content_ingridient.ingridient_id';
            $sql .= ' LEFT JOIN content ON content.id = content_ingridient.content_id';
        

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
