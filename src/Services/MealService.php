<?php

namespace App\Services;

use App\Repository\MealRepository;
use App\Transformers\MealTransformer;
use App\Services\PaginatorService;
use App\Validators\MealsRequestValidator;

final class MealService 
{

    private MealRepository $mealRepository;
    private MealTransformer $mealTransformer;
    private PaginatorService $paginator;
    private MealsRequestValidator $mealsRequestValidator;

    public function __construct(
        MealRepository $mealRepository,
        MealTransformer $mealTransformer,
        PaginatorService $paginator,
        MealsRequestValidator $mealsRequestValidator
        )
    {
        $this->mealRepository = $mealRepository;
        $this->mealTransformer = $mealTransformer;
        $this->paginator = $paginator;
        $this->mealsRequestValidator = $mealsRequestValidator;
    } 

    public function getMeals(array $parameters) : array
    {
        $errors = $this->mealsRequestValidator->validateRequestParameters($parameters);

        if ($errors !== null && count($errors) > 0) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        $parameters['limit'] = isset($parameters['per_page']) ? (int) $parameters['per_page'] : null;
        
        $parameters['offset'] = isset($parameters['page']) && $parameters['limit'] !== null ? ((int) $parameters['page'] - 1) * $parameters['limit'] : null;        

        $parameters['with'] = $this->_configureWithParameters($parameters['with'] ?? null);
        
        $query = $this->mealRepository->getMealsByCriteria($parameters);
        
        $pagination = $this->paginator->paginate($query);
        $totalItems = (int) $pagination['total'];
        
        $itemsPerPage = $parameters['limit'] ?? $totalItems;
        
        //$itemsPerPage = $parameters['limit'] ? : (int) 10 ;

        $transformedMeals = $this->mealTransformer->transformMeals($pagination['dataAsArray'], $parameters);
        
        $data['meta']['currentPage'] = $parameters['page'] ?? null;
        $data['meta']['totalItems'] = $totalItems;
        $data['meta']['itemsPerPage'] = $itemsPerPage;
        $data['meta']['totalPages'] = (int) ceil($totalItems / $itemsPerPage);
        $data['data'] = $transformedMeals;

        return $data;
    }

    private function _configureWithParameters(?string $param = null) : ?array
    {

        if ($param === null){
           return []; 
        }
        //dd(explode(',', $param));
        return explode(',', $param);
    }
}