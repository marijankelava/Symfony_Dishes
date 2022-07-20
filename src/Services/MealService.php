<?php

namespace App\Services;

use App\Repository\MealRepository;
use App\Transformers\MealTransformer;


final class MealService 
{

    private $mealRepository;
    private $mealTransformer;

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
        $with = [];

        if (isset($parameters['with'])){
        $with = explode(',', $parameters['with']);
        }
        
        $itemsPerPage = (int) $parameters['per_page'];
        $totalItems = $this->mealRepository->getMealsCount();
        $offset = ((int) $parameters['page'] - 1) * (int) $parameters['per_page'];
        $parameters['offset'] = $offset;

        $meals = $this->mealRepository->getMealsByCriteria($parameters, $with);

        $transformedMeals = $this->mealTransformer->transformMeals($meals);

        $data['meta']['currentPage'] = $parameters['page'];
        $data['meta']['totalItems'] = $totalItems;
        $data['meta']['itemsPerPage'] = $itemsPerPage;
        $data['meta']['totalPages'] = ceil($totalItems / $itemsPerPage);
        $data['data'] = $transformedMeals;

        return $data;
    }
}
