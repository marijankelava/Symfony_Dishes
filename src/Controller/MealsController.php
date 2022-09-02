<?php

namespace App\Controller;

use App\Services\MealService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Validators\MealsRequestValidator;

final class MealsController extends AbstractController
{
    private MealService $mealService;
    private MealsRequestValidator $mealsRequestValidator;

    public function __construct(
        MealService $mealService,
        MealsRequestValidator $mealsRequestValidator
        )
    {
        $this->mealService = $mealService;
        $this->mealsRequestValidator = $mealsRequestValidator;
    }

    /**
     * @Route("/api/meals", name="show", methods={"GET"})
     */
    public function getMeals(Request $request) : JsonResponse
    {   
        $parameters = $request->query->all();
        //dd($parameters);
        $errors = $this->mealsRequestValidator->validateRequest($parameters);
        //dd($errors);
        $data = $this->mealService->getMeals($parameters);
        dd($data);
        return $this->json($data);
    }
}
