<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use App\Repository\CategoryRepository;
use App\Repository\MealRepository;
use App\Repository\IngridientRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MealsController extends AbstractController
{
    private $mealRepository;
    private $categoryRepository;
    private $contentRepository;
    private $ingridientRepository;
    private $tagRepository;

    public function __construct(
        MealRepository $mealRepository, 
        CategoryRepository $categoryRepository, 
        ContentRepository $contentRepository, 
        IngridientRepository $ingridientRepository,
        TagRepository $tagRepository)
    {
        $this->mealRepository = $mealRepository;
        $this->categoryRepository = $categoryRepository;
        $this->contentRepository = $contentRepository;
        $this->ingridientRepository = $ingridientRepository;
        $this->tagRepository = $tagRepository;
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
        $with = [];
        if (isset($parameters['with'])){
        $with = explode(',', $parameters['with']);
        }

        //dd($with);

        $meals = $this->mealRepository->getMeals2($parameters, $with);
        //$categories = $this->categoryRepository->getCategoryTitle($parameters, $with);
        //$contents = $this->contentRepository->getContentTitle($parameters, $with);
        //$tags = $this->tagRepository->getTagsTitle($parameters, $with);
        $ingridients = $this->ingridientRepository->getIngridientsTitle($parameters, $with);
        dd($meals, $ingridients);

        return $this->json([
            //'categories' => $categories,
            'meals' => $meals
        ]);
    }

    /**
     * @Route("/api/meals/2", name="show2", methods={"GET"})
     */
    public function getMeals2(Request $request) : JsonResponse
    {
        $parameters = $request->query->all();
        $with = [];
        if (isset($parameters['with'])){
        $with = explode(',', $parameters['with']);
        }

        //dd($with);

        $meals = $this->mealRepository->getMeals2($parameters, $with);

        $categories = [];
        if (in_array('category', $with)) {
            $categories = $this->categoryRepository->getCategory($parameters);
        }

        $tags = [];
        if(in_array('tags', $with)) {
            $tags = $this->tagRepository->getTags($parameters);
        }

        $ingridients = [];
        if(in_array('ingridients', $with)) {
            $ingridients = $this->ingridientRepository->getIngridients($parameters);
        }

        //$contents = $this->contentRepository->getContentTitle($parameters);
        dd($meals, $categories, $tags, $ingridients);

        return $this->json([
            //'categories' => $categories,
            'meals' => $meals
        ]);
    }
}
