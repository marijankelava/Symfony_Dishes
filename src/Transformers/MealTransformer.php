<?php

namespace App\Transformers;

final class MealTransformer 
{
    public function transformMeals(array $meals) : array
    {
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
