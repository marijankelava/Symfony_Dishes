<?php

namespace App\Services;

use App\Repository\MealRepository;
use App\Transformers\MealTransformer;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class MealService 
{

    private MealRepository $mealRepository;
    private MealTransformer $mealTransformer;

    public function __construct(
        MealRepository $mealRepository,
        MealTransformer $mealTransformer
        )
    {
        $this->mealRepository = $mealRepository;
        $this->mealTransformer = $mealTransformer;
    } 

    public function getMeals(array $parameters)
    {
        $parameters['limit'] = isset($parameters['per_page']) ? (int) $parameters['per_page'] : null;
        $parameters['offset'] = isset($parameters['page']) && $parameters['limit'] !== null ? ((int) $parameters['page'] - 1) * $parameters['limit'] : null;        

        $parameters['with'] = $this->_configureWithParameters($parameters['with'] ?? null);

        $query = $this->mealRepository->getMealsByCriteria($parameters);
        $paginator = $this->_paginate($query);
        $totalItems = (int) $paginator['total'];

        $itemsPerPage = $parameters['limit'] ?? $totalItems;

        $transformedMeals = $this->mealTransformer->transformMeals($paginator['dataAsArray']);

        $data['meta']['currentPage'] = $parameters['page'] ?? null;
        $data['meta']['totalItems'] = $totalItems;
        $data['meta']['itemsPerPage'] = $itemsPerPage;
        $data['meta']['totalPages'] = (int) ceil($totalItems / $itemsPerPage);
        $data['data'] = $transformedMeals;

        return $data;
    }

    private function _paginate($query)
    {
        $paginator = new Paginator($query);
        $result['data'] = $paginator->getIterator();
        $result['dataAsArray'] = $result['data']->getArrayCopy(); 
        $result['total'] = $paginator->count();

        return $result;
    }

    private function _configureWithParameters(?string $param = null) : ?array
    {

        if ($param === null){
           return []; 
        }
        return explode(',', $param);
    }
}
