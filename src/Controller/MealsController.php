<?php

namespace App\Controller;

use App\Entity\Language;
use App\Repository\IngridientRepository;
use App\Repository\ContentRepository;
use App\Repository\MealRepository;
use App\Services\MealService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\ValidatorService;
use App\Validators\MealsRequestValidator;

class MealsController extends AbstractController
{
    private ContentRepository $contentRepository;
    private MealService $mealService;
    private IngridientRepository $ingridientRepository;
    private MealsRequestValidator $mealsRequestValidator;

    public function __construct(
        MealRepository $mealRepository, 
        ContentRepository $contentRepository, 
        MealService $mealService,
        IngridientRepository $ingridientRepository,
        MealsRequestValidator $mealsRequestValidator
        )
    {
        $this->mealRepository = $mealRepository;
        $this->contentRepository = $contentRepository;
        $this->mealService = $mealService;
        $this->ingridientRepository = $ingridientRepository;
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
