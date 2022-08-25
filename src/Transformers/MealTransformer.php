<?php

namespace App\Transformers;

final class MealTransformer 
{
    public function transformMeals(array $meals) : array
    {
        $y = 0;
        $data = [];
        foreach ($meals as $key => $meal) {
            $data[$key]['id'] = $meal['id'];    
            $data[$key]['title'] = $meal['title'];    
            $data[$key]['description'] = $meal['description'];
            $data[$key]['status'] = $meal['createdAt']; 
            
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

                $x = count($meals[$y][0]['ingridients']);

                for($i = 0; $i < $x; $i++){
                $data[$key]['ingridients'][$i]['id'] = $meal[0]['ingridients'][$i]['id'];  
                $data[$key]['ingridients'][$i]['title'] = $meal[0]['ingridients'][$i]['contents'][0]['title']; 
                $data[$key]['ingridients'][$i]['slug'] = $meal[0]['ingridients'][$i]['slug'];
                }; 
            }
            $y++;

        }
        return $data;
    }
} 