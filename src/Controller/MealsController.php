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
use App\Services\RequestValidatorService;

class MealsController extends AbstractController
{
    private ContentRepository $contentRepository;
    private MealService $mealService;
    private IngridientRepository $ingridientRepository;
    private RequestValidatorService $requestValidatorService;

    public function __construct(
        MealRepository $mealRepository, 
        ContentRepository $contentRepository, 
        MealService $mealService,
        IngridientRepository $ingridientRepository,
        RequestValidatorService $requestValidatorService
        )
    {
        $this->mealRepository = $mealRepository;
        $this->contentRepository = $contentRepository;
        $this->mealService = $mealService;
        $this->ingridientRepository = $ingridientRepository;
        $this->requestValidatorService = $requestValidatorService;
    }

    /**
     * @Route("/api/meals", name="show", methods={"GET"})
     */
    public function getMeals(Request $request) : JsonResponse
    {   
        $parameters = $request->query->all();
        //dd($parameters);
        $errors = $this->requestValidatorService->validateRequest($parameters);
        //dd($errors);
        $data = $this->mealService->getMeals($parameters);
        dd($data);
        return $this->json($data);
    }
}
