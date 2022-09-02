<?php

namespace App\Controller\Api\V1\Meals;

use App\Services\MealService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Retrieve extends AbstractController
{
    private MealService $mealService;

    public function __construct(
        MealService $mealService
        )
    {
        $this->mealService = $mealService;
    }

    /**
     * @Route("/meals/v1", name="show", methods={"GET"})
     */
    public function getMeals(Request $request) : JsonResponse
    {   
        $parameters = $request->query->all();
        //dd($parameters);

        $data = $this->mealService->getMeals($parameters);
        dd($data);
        return $this->json($data);
    }
}