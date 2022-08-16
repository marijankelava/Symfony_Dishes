<?php

namespace App\Services;

use App\Repository\MealRepository;
use App\Transformers\MealTransformer;

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
        
        if (!isset($parameters['per_page'])) {
            $per_page = $this->mealRepository->getMealsCount();
        } else{
            $per_page = (int) $parameters['per_page'];
        }
        
        $page = 1;
        if (isset($parameters['page'])) {
            $page = (int) $parameters['page'];
        }

        $itemsPerPage = (int) $per_page;
        $totalItems = $this->mealRepository->getMealsCount();
        $offset = ((int) $page - 1) * (int) $per_page;
        $parameters['offset'] = $offset;
        $parameters['with'] = $this->_configureWithParameters($parameters);

        /*$itemsPerPage = (int) $parameters['per_page'];
        $totalItems = $this->mealRepository->getMealsCount();
        $offset = ((int) $parameters['page'] - 1) * (int) $parameters['per_page'];
        $parameters['offset'] = $offset;
        $parameters['with'] = $this->_configureWithParameters($parameters);*/

        $paginatorResult = $this->mealRepository->getMealsByCriteria($parameters);
        $meals = $paginatorResult['data']->getArrayCopy();

        $transformedMeals = $this->mealTransformer->transformMeals($meals);

        $data['meta']['currentPage'] = $page;
        //$data['meta']['currentPage'] = $parameters['page'];
        $data['meta']['totalItems'] = $totalItems;
        $data['meta']['itemsPerPage'] = $itemsPerPage;
        $data['meta']['totalPages'] = ceil($totalItems / $itemsPerPage);
        $data['data'] = $transformedMeals;

        return $data;
    }

    private function _configureWithParameters(array $parameters) : ?array
    {

        if (!isset($parameters['with'])){
           return []; 
        }
        return explode(',', $parameters['with']);
    }
}
