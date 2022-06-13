<?php

namespace App\Services;

use App\Repository\MealRepository;

final class QueryService extends MealRepository
{
    /*public function findByCategoryId(int $id)
    {
        $qb = $this->createQueryBuilder('m');

        $qb->leftJoin('m.category', 'c',)
            ->addSelect('c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id);
        
        return $qb->getQuery()->getResult();
    }*/
}



