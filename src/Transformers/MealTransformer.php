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
            //dd($meals);
            if (isset($meal[0]['category'][0])) {
                $data[$key]['category']['id'] = $meal[0]['category'][0]['id'];  
                $data[$key]['category']['title'] = $meal[0]['category'][0]['contents'][0]['title'];  
                $data[$key]['category']['slug'] = $meal[0]['category'][0]['slug']; 
            }

            if (isset($meal[0]['tags'][0])) {
                $data[$key]['tags']['id'] = $meal[0]['tags'][0]['id'];  
                $data[$key]['tags']['title'] = $meal[0]['tags'][0]['contents'][0]['title'];  
                $data[$key]['tags']['slug'] = $meal[0]['tags'][0]['slug']; 
            }

            if (isset($meal[0]['ingridients'][0])) {
                $data[$key]['ingridients']['id'] = $meal[0]['ingridients'][0]['id'];  
                $data[$key]['ingridients']['title'] = $meal[0]['ingridients'][0]['contents'][0]['title'];  
                $data[$key]['ingridients']['slug'] = $meal[0]['ingridients'][0]['slug']; 
            }
        }
        //dd($data);
        return $data;
    }
}
