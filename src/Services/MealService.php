<?php

namespace App\Services;

use App\Repository\MealRepository;

final class MealService 
{

    private $mealRepository;

    public function __construct(
        MealRepository $mealRepository
        )
    {
        $this->mealRepository = $mealRepository;
    } 

    public function getMeals(array $parameters)
    {
        $with = [];
        
        if (isset($parameters['with'])){
        $with = explode(',', $parameters['with']);
        }

        $meals = $this->mealRepository->getMealsByCriteria($parameters, $with);

        $data = [];
        foreach ($meals as $key => $meal) {
            $data['data'][$key]['id'] = $meal['id'];    
            $data['data'][$key]['title'] = $meal['title'];    
            $data['data'][$key]['description'] = $meal['description']; 
            $data['data'][$key]['category']['id'] = $meal[0]['category'][0]['id'];  
            $data['data'][$key]['category']['title'] = $meal[0]['category'][0]['contents'][0]['title'];  
            $data['data'][$key]['category']['slug'] = $meal[0]['category'][0]['slug']; 
        }
        return $data;
    }
}
