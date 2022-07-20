<?php

namespace App\Transformers;

final class MealTransformer 
{
    public function transformMeals(array $meals) : array
    {
        $data = [];
        foreach ($meals as $key => $meal) {
            $data[$key]['id'] = $meal['id'];    
            $data[$key]['title'] = $meal['title'];    
            $data[$key]['description'] = $meal['description']; 

            if (isset($meal[0]['category'][0])) {
                $data[$key]['category']['id'] = $meal[0]['category'][0]['id'];  
                $data[$key]['category']['title'] = $meal[0]['category'][0]['contents'][0]['title'];  
                $data[$key]['category']['slug'] = $meal[0]['category'][0]['slug']; 
            }
        }
        return $data;
    }
}
