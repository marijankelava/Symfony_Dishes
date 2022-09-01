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
     * @Route("/meals", name="meals", defaults={"name" = null}, methods={"GET", "HEAD"})
     */
    public function index(Request $request): Response
    {
        $parameters = $request->query->all();

        $meals = $this->mealRepository->getAllMeals();

        //$meals = $this->contentRepository->findBy(["fqcn" => "App\Entity\Meal"]);
        //$categories = $this->contentRepository->showCategories();
        $categories = [];
        return $this->render('meal/index.html.twig', [
            'categories' => $categories,
            'meals' => $meals
        ]);
    }

    /**
     * @Route("/meal/{id}", name="meal", methods={"GET"})
     */
    public function showMeal($id): Response
    {
        $meal = $this->contentRepository->find($id);
        //$categories = $this->categoryRepository->findBy();
        $categories = [];

        return $this->render('meal/show.html.twig', [
            'categories' => $categories,
            'meal' => $meal
        ]);
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

    /**
     * @Route("api/meals/category", name="category", methods={"GET"})
     */
    /*public function getMealsByCategory(Request $request): JsonResponse
    {
        $parameters = $request->query->all();

        $categories = [];
        if (isset($parameters['category'])) {
            $categoryId = explode(',', $parameters['category']);
            $categories = $this->mealRepository->getMealsByCategory($parameters, $categoryId);  
        }
        dd($categories);

        return $this->render('meal/show.html.twig', [
            'categories' => $categories,
            'meal' => $meal
        ]);
    }*/

    /**
     * @Route("api/meals/tags", name="tags", methods={"GET"})
     */
    /*public function getMealsByTags(Request $request): JsonResponse
    {
        $parameters = $request->query->all();

        $tags = [];
        if (isset($parameters['tags'])) {
            $tagId = explode(',', $parameters['tags']);
            $tags = $this->mealRepository->getMealsByTags($parameters, $tagId);  
        }
        dd($tags);
        return $this->render('meal/show.html.twig', [
            'categories' => $categories,
            'meal' => $meal
        ]);
    }*/
}
