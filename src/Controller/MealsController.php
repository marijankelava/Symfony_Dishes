<?php

namespace App\Controller;

use App\Repository\IngridientRepository;
use App\Repository\ContentRepository;
use App\Repository\MealRepository;
use App\Services\MealService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MealsController extends AbstractController
{
    private ContentRepository $contentRepository;
    private MealService $mealService;
    private IngridientRepository $ingridientRepository;

    public function __construct(
        MealRepository $mealRepository, 
        ContentRepository $contentRepository, 
        MealService $mealService,
        IngridientRepository $ingridientRepository
        )
    {
        $this->mealRepository = $mealRepository;
        $this->contentRepository = $contentRepository;
        $this->mealService = $mealService;
        $this->ingridientRepository = $ingridientRepository;
    }

    /**
     * @Route("/meals", name="meals", defaults={"name" = null}, methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        $meals = $this->contentRepository->findBy(["fqcn" => "App\Entity\Meal"]);
        $categories = $this->contentRepository->showCategories();
        //$categories = [];
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

        if (isset($parameters['category'])) {
            $categoryId = explode(',', $parameters['category']);
            $categories = $this->mealRepository->findByCategoryId($parameters, $categoryId);  
        }

        if (isset($parameters['tag'])) {
            $tagId = explode(',', $parameters['tag']);
            $tag = $this->mealRepository->findByTagId($parameters, $tagId);  
        }

        //$categoryId = explode(',', $parameters['category']);
        //$tagId = explode(',', $parameters['tag']);
        //$categories = $this->mealRepository->findByCategoryId($parameters, $categoryId);
        //$tag = $this->mealRepository->findByTagId($parameters, $tagId);
        //$data = $this->mealService->getMeals($parameters);
        dd($tag);
        return $this->json($data);
    }
}
