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

        $meals = $this->mealRepository->getMealsByCriteria($parameters, $with);

        $data = $this->mealTransformer->transformMeals($meals);

        return $data;
    }
}
