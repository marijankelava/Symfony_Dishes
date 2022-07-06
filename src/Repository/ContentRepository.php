<?php

namespace App\Repository;

use App\Entity\Content;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Content|null find($id, $lockMode = null, $lockVersion = null)
 * @method Content|null findOneBy(array $criteria, array $orderBy = null)
 * @method Content[]    findAll()
 * @method Content[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Content $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Content $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Content[] Returns an array of Content objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Content
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getRawSqlMeals($parameters)
    {
        $conn = $this->getEntityManager()->getConnection();

        // calculate offset
        $offset = ((int) $parameters['page'] - 1) * (int) $parameters['per_page'];
    
        $sql = 'SELECT content.id, content.title, content.description FROM content';
                
        if (isset($parameters['tag'])) {
            $sql .= ' LEFT JOIN content_tag ON content.id = content_tag.content_id
            WHERE tag_id IN (:tag)';
        }

        if (isset($parameters['category'])) {
            $sql .= ' LEFT JOIN content_category ON content.id = content_category.content_id
            WHERE category_id IN (:cat)';
        }

        if (isset($parameters['lang'])) {
            $sql .= ' AND language_id = :lang';
        }

        $sql .= ' LIMIT :limit OFFSET :offset';
        
        $stmt = $conn->prepare($sql);

        if (isset($parameters['lang'])) {
            $stmt->bindValue('lang', $parameters['lang']);
        }

        if (isset($parameters['tag'])) {
            $stmt->bindValue('tag', $parameters['tag']);
        }

        if (isset($parameters['category'])) {
            $stmt->bindValue('cat', $parameters['category']);
        }

        $stmt->bindValue('limit', $parameters['per_page'], \PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);

        $resultSet = $stmt->executeQuery();
    
        return $resultSet->fetchAllAssociative();    
    }

    public function showCategories()
    {
       $qb = $this->createQueryBuilder('con')
            ->andWhere('con.id IN (29, 30, 31)');
       
       return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function getContentTitle(array $parameters)
    {
        $val = "App\Entity\Category";
        $qb = $this->createQueryBuilder('con')
                   ->select('con.title')
                   ->andWhere('con.fqcn = :val')
                   ->setParameter('val', $val)
                   ->leftJoin('con.category', 'cat')
                   ->addSelect('cat.id', 'cat.slug');
        if (isset($parameters['lang'])) {
               $qb->andWhere('con.languageId = :lang')
               ->setParameter('lang', $parameters['lang']);
        }
        
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
}
